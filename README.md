# Licom Bundle

## Useful commands
app/console doctrine:schema:drop --em=licom --full-database --force
app/console doctrine:schema:update --em=licom --force

## Fixtures

You can load fixtures from src/Visca/Bundle/LicomBundle/Resources/config/fixtures/alice/sets

Ex: app/console visca:licom:fixtures:load single-match

## Dynamic attributes (aka Aux)

To use easily Aux data, there is a bunch of interfaces and traits:

- AuxInterface: To be implemented in the aux entity (Ex: ParticipantAux)
- AuxTypeInterface: To be implemented in the aux type entity (Ex: ParticipantAuxType)
- EntityWithAuxInterface: To be implemented in the entity that have a oneToMany to aux (Ex: Participant) 
- EntityWithAuxTrait: To be used in the entity that have a oneToMany to aux (Ex: Participant) 

Then in the entity you have a method : getAuxByKey

## Constants

Values from unique keys are available in Visca\Bundle\LicomBundle\Entity

The full class name is made like this : 
Visca\Bundle\LicomBundle\Entity\{uniquePropertyName}\{entityName}{uniquePropertyName}

So if you have MatchStatusDescription::code values are in MatchStatusDescriptionCode

## Enums

Some properties are ENUM using the following bundle : https://github.com/fre5h/DoctrineEnumBundle

All enums are in this namespace : Visca\Bundle\LicomBundle\Entity\Enum

The full class name is made like this : 
Visca\Bundle\LicomBundle\Entity\Enum\{entityName}{propertyName}Type

There are some exceptions to that rule

## Slug for the entities

Please note that we copied the rules used in LSOS for the Licom entities.

Therefore, here is the list of each entity and where the slug is found: 

Entity             |Using the slug related to...|Table in LSOS
-------------------|----------------------------|-------------
Country            |The language of the site    |cache\_name_lang
Sport              |The language of the site    |cache\_name_lang
Participant        |The site itself             |cache\_name_site
Competition        |The language of the site    |cache\_name_site
CompetitionCategory|The site itself             |cache\_name_lang