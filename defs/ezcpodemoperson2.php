<?php
$def = new ezcPersistentObjectDefinition();
$def->table = "person2";
$def->class = "ezcpoDemoPerson2";

$def->properties["firstname"] = new ezcPersistentObjectProperty();
$def->properties["firstname"]->columnName = "firstname";
$def->properties["firstname"]->propertyName = "firstname";
$def->properties["firstname"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties["lastname"] = new ezcPersistentObjectProperty();
$def->properties["lastname"]->columnName = "lastname";
$def->properties["lastname"]->propertyName = "lastname";
$def->properties["lastname"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties["age"] = new ezcPersistentObjectProperty();
$def->properties["age"]->columnName = "age";
$def->properties["age"]->propertyName = "age";
$def->properties["age"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = "person_id";
$def->idProperty->propertyName = "id";
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    "ezcPersistentNativeGenerator"
);

$def->relations["ezcpoDemoAddress2"] = new ezcPersistentOneToManyRelation( "person2", "address2" );
$def->relations["ezcpoDemoAddress2"]->columnMap = array(
    new ezcPersistentSingleTableMap( "firstname", "person_firstname" ), 
    new ezcPersistentSingleTableMap( "lastname", "person_lastname" )
);
$def->relations["ezcpoDemoAddress2"]->cascade = true;

return $def;
?>