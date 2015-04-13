<?php
/**
 * ezcpoAnnotationVisitor
 *
 * @package Annotation
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
interface ezcpoAnnotationVisitor extends ezcpoReflectionVisitor
{   
    function visitAnnotationGenerator( ezcpoAnnotationGenerator $generator );

    function visitAnnotationManyToMany( ezcpoAnnotationManyToMany $manyToMany );
    
    function visitAnnotationOneToMany( ezcpoAnnotationOneToMany $oneToMany );

    function visitAnnotationOneToOne( ezcpoAnnotationOneToOne $oneToOne );

    function visitAnnotationPersistent( ezcpoAnnotationPersistent $persistent );
    
    function visitAnnotationProperty( ezcpoAnnotationProperty $property );
}