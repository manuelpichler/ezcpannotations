<?php
$def = new ezcPersistentObjectDefinition();
$def->table = "address2";
$def->class = "ezcpoDemoAddress2";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = "address_id";
$def->idProperty->propertyName = "id";
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(
    "ezcPersistentNativeGenerator"
);

$def->properties["personFirstname"] = new ezcPersistentObjectProperty();
$def->properties["personFirstname"]->columnName = "person_firstname";
$def->properties["personFirstname"]->propertyName = "personFirstname";
$def->properties["personFirstname"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties["personLastname"] = new ezcPersistentObjectProperty();
$def->properties["personLastname"]->columnName = "person_lastname";
$def->properties["personLastname"]->propertyName = "personLastname";
$def->properties["personLastname"]->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

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

$def->relations["ezcpoDemoPerson2"] = new ezcPersistentOneToOneRelation( "address2", "person2" );
$def->relations["ezcpoDemoPerson2"]->columnMap = array(
    new ezcPersistentSingleTableMap( "person_firstname", "firstname" ), 
    new ezcPersistentSingleTableMap( "person_lastname", "lastname" )
);

return $def;
?>