<?php
/**
 * ezcpoReflectionParser
 *
 * @package Reflection
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcpoReflectionParser 
{
    
    /**
     * The context php doc comment.
     * 
     * @type string
     * @var string $docComment
     */
    protected $docComment = "";
    
    /**
     * Constructor takes the doc comment as argument.
     * 
     * @param string $docComment
     */
    public function __construct( $docComment )
    {
        $this->docComment = $docComment;
    }
    
    /**
     * This method parses the doc comment and loads the annotation objects.
     * 
     * @return array 
     */
    public function parse( ezcpoReflectionAnnotated $annotated )
    {
        // Init annotation array
	    $annotations = array();
	    
	    // Quick check for any annotation or doc block tag
	    if ( strpos( $this->docComment, "@" ) === false )
	    {
	        return $annotations;
	    }

	    // Extract annotations from doc comment
	    if ( preg_match_all( "#\*\s*@([A-Z][\w]+)(\(([^\)]+)\))?#", $this->docComment, $matches ) )
	    {
	        
	        // Build annotation data
	        foreach ( $matches[1] as $i => $annotationName )
	        {
	            
	            // Build class name
	            $className = "ezcpoAnnotation{$annotationName}";
	            
	            // Create annotation instance
	            $annotation = new $className( $annotated, $annotationName );
	            
	            // Extract parameter
	            if ( !preg_match_all( "#([\w]+)=([\w\+;]+)#", $matches[3][$i], $parameters ) )
	            {
	                 continue;   
	            }
	            
	            foreach ( $parameters[1] as $j => $parameterName )
	            {
	                // Set property
	                $annotation->{$parameterName} = $parameters[2][$j];
	            }
	             
	            // Store annotation
	            $annotations[] = $annotation;
	        }
	    }
	    
	    return $annotations;

    }
}