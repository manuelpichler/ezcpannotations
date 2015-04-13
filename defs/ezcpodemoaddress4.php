<?php
$def = new ezcPersistentObjectDefinition();
$def->table = "address4";
$def->class = "ezcpoDemoAddress4";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = "address_id";
$def->idProperty->propertyName = "id";
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    "ezcPersistentNativeGenerator"
);

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

$def->relations["ezcpoDemoPerson4"] = new ezcPersistentManyToManyRelation( "address4", "person4", "person4_address4" );
$def->relations["ezcpoDemoPerson4"]->columnMap = array(
    new ezcPersistentDoubleTableMap( "address_id", "address_fid", "person_firstname", "firstname" ),
    new ezcPersistentDoubleTableMap( "address_id", "address_fid", "person_lastname", "lastname" )
);

return $def;
?>