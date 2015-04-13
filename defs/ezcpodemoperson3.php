<?php
$def = new ezcPersistentObjectDefinition();
$def->table = "person3";
$def->class = "ezcpoDemoPerson3";

$def->properties["name"] = new ezcPersistentObjectProperty();
$def->properties["name"]->columnName = "full_name";
$def->properties["name"]->propertyName = "name";
$def->properties["name"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

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

$def->relations["ezcpoDemoAddress3"] = new ezcPersistentManyToManyRelation( "person3", "address3", "person3_address3" );
$def->relations["ezcpoDemoAddress3"]->columnMap = array(
    new ezcPersistentDoubleTableMap( "person_id", "person_fid", "address_fid", "address_id" )
);

return $def;
?>