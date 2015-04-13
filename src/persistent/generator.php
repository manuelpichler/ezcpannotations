<?php
/**
 * ezcpoPersistentObjectGenerator
 *
 * @package PersistentObject
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcpoPersistentObjectGenerator implements ezcpoAnnotationVisitor 
{
    /**
     * The reflection object for the context class.
     *
     * @type ezcpoReflectionClass
     * @var ezcpoReflectionClass $reflection
     */
    protected $reflection = null;
    
    /**
     * Enter description here...
     *
     * @type SimpleXMLElement
     * @var SimpleXMLElement $document
     */
    protected $document = null;
    
    /**
     * The constructor takes the context class name as argument.
     *
     * @param mixed $class The class name or an instance of 
     * <tt>ezcpoReflectionClass</tt>
     */
    public function __construct( $class )
    {
        if ( $class instanceof ezcpoReflectionClass  )
        {
            // Store reflection class instance
            $this->reflection = $class;
        } 
        else 
        {
            // Create a reflection instance 
	        $this->reflection = new ezcpoReflectionClass( $class );
        }
    }
    
    /**
     * This method generates the definition file. 
     *
     * @param string $fileName The definition file.
     */
    public function generate( $fileName )
    {
        // Check for persistent annotation
	    if ( !$this->reflection->hasAnnotation( "Persistent" ) )
	    {
	        throw new Exception( "The class " . $this->reflection->getName() . " is not persistent." );
	    }
	    
	    $this->document = new SimpleXMLElement( "<definition />" );
	    
        $this->reflection->visit( $this );
        
        $dom = dom_import_simplexml( $this->document )->ownerDocument;
        $dom->formatOutput = true;
        
        $xsl = new DOMDocument();
        $xsl->load( dirname( __FILE__ ) . "/data/code.xsl" );
        
//        print $dom->saveXML();

        $processor = new XSLTProcessor();
        $processor->importStylesheet( $xsl );
        $definition = $processor->transformToXml( $dom );
//print $definition;
        // Store content
        file_put_contents( $fileName, $definition );
    }
    
    public function visitAnnotationGenerator( ezcpoAnnotationGenerator $generator )
    {
         
        // Get index for the last property
        $lastIndex = ( count( $this->document->properties->property ) - 1 );
        
        // Get last persistent property
	    $property = $this->document->properties->property[$lastIndex];
         
	    // Add a new element for the id generator
	    $element = $property->addChild( "generator" );
	    
	    // Add generator type attribute
        $element->addAttribute( "generatorType", $generator->type );
	    
        // Add optional generator parameter
        if ( trim( $generator->param ) !== "" )
	    {
	        $element->addAttribute( "generatorParam", $generator->param );
	    }
    }

    public function visitAnnotationManyToMany( ezcpoAnnotationManyToMany $manyToMany )
    {
        // Call common visit method, if the return value is null skip here
        if ( ( $element = $this->buildCommonRelation( $manyToMany ) ) === null )
        {
            return;
        }

        // Set relation type
        $element->addAttribute( "relationType", "many-to-many" );
        
        // Set additional attributes
        $element->addAttribute( "relationTableName", $manyToMany->table );
        $element->addAttribute( "across",            $manyToMany->columns );
    }

    public function visitAnnotationOneToMany( ezcpoAnnotationOneToMany $oneToMany )
    {
        // Call common visit method, if the return value is null skip here
        if ( ( $element = $this->buildCommonRelation( $oneToMany ) ) === null )
	    {
	        return;
	    }
        
        $element->addAttribute( "relationType", "one-to-many" );
    }
    
    public function visitAnnotationOneToOne( ezcpoAnnotationOneToOne $oneToOne )
    {
        // Call common visit method, if the return value is null skip here
        if ( ( $element = $this->buildCommonRelation( $oneToOne ) ) === null )
        {
            return;
        }

        // Add relation type
        $element->addAttribute( "relationType", "one-to-one" );
    }
    
    public function visitAnnotationPersistent( ezcpoAnnotationPersistent $persistent )
    {
        // We know there is only one element
        $this->document->object->addAttribute( "tableName", $persistent->table );
    }
    
    public function visitAnnotationProperty( ezcpoAnnotationProperty $property )
    {
        $element = $this->document->properties->addChild( "property" );
         
        $element->addAttribute( "columnName", $property->column );
	    $element->addAttribute( "propertyType", $property->type );
	    
	    // Is this the id property?
	    if ( $property->id === true )
	    {
	        $element->addAttribute( "propertyIsId", "true" );
	    }

	    // The property name is optional for real properties
	    if ( (string) $property->name !== "" )
	    {
	        $element->addAttribute( "propertyName", $property->name );
	    }
    }
    
    public function visitReflectionClass( ezcpoReflectionClass $class ) 
    {
        // Create the persistent object element
        $this->document->addChild( "object" );
        $this->document->object->addAttribute( "className", $class->getName() );
        
        // Create the properties and relations elements
	    $this->document->addChild( "properties" );
        $this->document->addChild( "relations" );
        
        // Traverse all annotations
	    foreach ( $class->getAnnotations() as $annotation )
	    {
	        $annotation->visit( $this );
	    }
	    
	    // Traverse all properties
	    foreach ( $class->getProperties() as $property )
	    {
	        $property->visit( $this );
	    }
    }
    
    public function visitReflectionProperty( ezcpoReflectionProperty $property )
    {
        // Check for property annotation
	    if ( !$property->hasAnnotation( "Property" ) )
	    {
	        return;
	    }

        // Traverse all annotations
	    foreach ( $property->getAnnotations() as $annotation )
	    {
	        $annotation->visit( $this );
	    }
	    
	    // Get index for the last property
	    $lastIndex = ( count( $this->document->properties->property ) - 1 );
	    
	    // For real properties check property name
	    if ( !isset( $this->document->properties->property[$lastIndex]["propertyName"] ) )
	    {
	        $this->document->properties->property[$lastIndex]["propertyName"] = $property->getName();
	    }
    }
    
    /**
     * This method generates the common part for all relations.
     *
     * @param ezcpoAnnotationRelation $relation
     * @return SimpleXMLElement The definition element or <tt>null</tt>.
     * 
     * @throws ezcPersistentRelationNotDefinedException
     */
    protected function buildCommonRelation( ezcpoAnnotationRelation $relation )
    {
        // Load relation class
        $reflection = new ezcpoReflectionClass( $relation->class );
         
        // Check that this class is persistent
        if ( !$reflection->hasAnnotation( "Persistent" ) )
        {
            // Returning null means nothing todo
            return null;
        }

        // Add relation element
        $element = $this->document->relations->addChild( "relation" );

        // Set common attributes
        $element->addAttribute( "className", $relation->class  );
        $element->addAttribute( "tableName", $reflection->getAnnotation( "Persistent" )->table );
         
        // Add relation columns
        $element->addAttribute( "from", $this->getRelationFrom( $relation ) );
        $element->addAttribute( "to",   $this->getRelationTo( $relation ) );

        // Check for cascade property
        if ( $relation->cascade === true )
        {
            $element->addAttribute( "cascade", "true" );
        }
        
        return $element;
    }
    
    protected function getRelationFrom( ezcpoAnnotationRelation $relation )
    {
        // Check for a defined from property
	    if ( $relation->from !== "" )
	    {
	        return $relation->from;
	    } 
	    else if ( $relation->annotatedObject instanceof ezcpoReflectionClass  )
	    {
            // Search for id column
            return $this->searchIdColumn( $relation->annotatedObject );
	    }
	    else if ( $relation->annotatedObject instanceof ezcpoReflectionProperty  ) 
	    {
	        return $relation->annotatedObject->getAnnotation( "Property" )->column;
	    }

	    throw new ezcPersistentRelationNotDefinedException(
	        (string) $this->document->object["className"]
	    );
    }
    
    protected function getRelationTo( ezcpoAnnotationRelation $relation )
    {
        // Check for a defined to property
	    if ( $relation->to !== "" )
	    {
	        return $relation->to; 
	    }
	    else if ( $relation->class !== "" )
	    {
	        // It's a class reflection and the to property is not set it must be
	        // a foreign key search.
	        if ( $relation->annotatedObject instanceof ezcpoReflectionClass )
	        {
	            return $this->searchForeignColumn( new ezcpoReflectionClass( $relation->class ) );
	        }
	        // Search for id column
	        return $this->searchIdColumn( new ezcpoReflectionClass( $relation->class ) );
	    }

	    throw new ezcPersistentRelationNotDefinedException(
	        (string) $this->document->object["className"]
	    );
    }
    
    /**
     * This method searches for the id column name in the given class.
     * 
     * @param ezcpoReflectionClass $reflection
     * @return string
     * 
     * @throws ezcPersistentRelationNotDefinedException
     */
    protected function searchIdColumn( ezcpoReflectionClass $reflection )
    {
        // Get all annotations for class
        foreach ( $reflection->getAnnotations( "Property" ) as $annotation )
        {
            // if it is the id property return it
            if ( $annotation->id === true )
            {
                return $annotation->column;
            }
        }

        // No class id annotation found
        foreach ( $reflection->getProperties() as $property )
        {
            // Get all property annotations
            foreach ( $property->getAnnotations( "Property" ) as $annotation )
            {
                // if it is the id property return it
                if ( $annotation->id === true )
                {
                    return $annotation->column;
                }
            }
        }

        throw new ezcPersistentRelationNotDefinedException(
            (string) $this->document->object["className"]
        );
    }
    
    /**
     * This method will search for a foreign key column in the given class.
     *
     * @param ezcpoReflectionClass $reflection
     * @return string
     * 
     * @throws ezcPersistentRelationNotDefinedException
     */
    protected function searchForeignColumn( ezcpoReflectionClass $reflection )
    {
        // Get all annotations for class
        foreach ( $reflection->getAnnotations() as $annotation )
        {
            // Skip if it isn't a relation
            if ( !( $annotation instanceof ezcpoAnnotationRelation ) )
            {
                continue;
            }
            // Compare with context class
	        if ( (string) $this->document->object["className"] === $annotation->class )
	        {
	            // Is the target column defined?
	            if ( $annotation->from !== "" )
	            {
	                return $annotation->from;
	            }
	            // Use primary key
	            else
	            {
	                return $this->searchIdColumn( $reflection );
	            }
	        }
        }
        
        // Search in class properties
        foreach ( $reflection->getProperties() as $property )
        {
            // Get all property annotations
            foreach ( $property->getAnnotations() as $annotation )
            {
                // Skip if it isn't a relation
                if ( !( $annotation instanceof ezcpoAnnotationRelation ) )
                {
                    continue;
                }
                // Compare with context class
                if ( (string) $this->document->object["className"] === $annotation->class )
                {
                    // Get property annotation and return column name
	                return $property->getAnnotation( "Property" )->column;
	            }
            }
        }

        throw new ezcPersistentRelationNotDefinedException(
            (string) $this->document->object["className"]
        );
    }
}