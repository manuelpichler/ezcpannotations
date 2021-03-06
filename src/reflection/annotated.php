<?php
/**
 * ezcpoReflectionAnnotated
 *
 * @package Reflection
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
interface ezcpoReflectionAnnotated
{
    
    function hasAnnotation( $name );
    
    function getAnnotation( $name );
    
    function getAnnotations( $annotationName = null );
    
    function getDocComment();
}