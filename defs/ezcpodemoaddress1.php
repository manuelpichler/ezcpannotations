<?php
$def = new ezcPersistentObjectDefinition();
$def->table = "address1";
$def->class = "ezcpoDemoAddress1";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = "address_id";
$def->idProperty->propertyName = "id";
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    "ezcPersistentNativeGenerator"
);

$def->properties["person"] = new ezcPersistentObjectProperty();
$def->properties["person"]->columnName = "person_fid";
$def->properties["person"]->propertyName = "person";
$def->properties["person"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties["street"] = new ezcPersistentObjectProperty();
$def->properties["street"]->columnName = "street";
$def->properties["street"]->propertyName = "street";
$def->properties["street"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties["zip"] = new ezcPersistentObjectProperty();
$def->properties["zip"]->columnName = "zip";
$def->properties["zip"]->propertyName = "zip";
$def->properties["zip"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties["city"] = new ezcPersistentObjectProperty();
$def->properties["city"]->columnName = "city";
$def->properties["city"]->propertyName = "city";
$def->properties["city"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->relations["ezcpoDemoPerson1"] = new ezcPersistentOneToOneRelation( "address1", "person1" );
$def->relations["ezcpoDemoPerson1"]->columnMap = array(
    new ezcPersistentSingleTableMap( "person_fid", "person_id" )
);

return $def;
?>