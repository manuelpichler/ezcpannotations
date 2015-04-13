<?php
$def = new ezcPersistentObjectDefinition();
$def->table = "person1";
$def->class = "ezcpoDemoPerson1";

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

$def->relations["ezcpoDemoAddress1"] = new ezcPersistentOneToManyRelation( "person1", "address1" );
$def->relations["ezcpoDemoAddress1"]->columnMap = array(
    new ezcPersistentSingleTableMap( "person_id", "person_fid" )
);
$def->relations["ezcpoDemoAddress1"]->cascade = true;

return $def;
?>