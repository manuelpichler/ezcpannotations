<?php
/**
 * ezcpoDemoPerson2
 *
 * @package Demo
 * @version 0.1
 * @copyright Copyright (C) 2007 Manuel Pichler. All rights reserved.
 * @author Manuel Pichler <mapi@manuel-pichler.de>
 * @license http://ez.no/licenses/new_bsd New BSD License
 *
 * @Persistent(table=person2)
 * @OneToMany(class=ezcpoDemoAddress2,from=firstname+lastname,to=person_firstname+person_lastname,cascade=true)
 * @Property(name=firstname,column=firstname,type=string)
 * @Property(name=lastname,column=lastname,type=string)
 * @Property(name=age,column=age,type=int)
 */
class ezcpoDemoPerson2
{

    /**
     * Enter description here...
     *
     * @Property(column=person_id,type=int,id=true)
     * @Generator(type=native)
     */
    protected $id;

    /**
     * All properties for a person object.
     *
     * @type array<mixed>
     * @var array $properties
     */
    protected $properties = array();

    public function __construct()
    {
        // Setup properties
        $this->properties = array(
            "firstname"  =>  "",
            "lastname"   =>  "",
            "age"        =>  0,
        );
    }

    public function getState()
    {
        return array(
            "id"         =>  $this->id,
            "firstname"  =>  $this->properties["firstname"],
            "lastname"   =>  $this->properties["lastname"],
            "age"        =>  $this->properties["age"]
        );
    }

    public function setState( array $state )
    {
        $this->id        = $state["id"];
        $this->firstname = $state["firstname"];
        $this->lastname  = $state["lastname"];
        $this->age       = $state["age"];
    }

    public function __get( $name )
    {
        switch ( $name )
        {
            case "id":
                return $this->id;

            default:
                if ( array_key_exists( $name, $this->properties ) )
                {
                    return $this->properties[$name];
                }
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case "firstname":
            case "lastname":
            case "age":
                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );
        }
    }
}