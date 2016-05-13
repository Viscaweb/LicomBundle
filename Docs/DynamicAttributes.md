## Dynamic attributes (aka Aux)

To use easily Aux data, there is a bunch of interfaces and traits:

- AuxInterface: To be implemented in the aux entity (Ex: ParticipantAux)
- AuxTypeInterface: To be implemented in the aux type entity (Ex: ParticipantAuxType)
- EntityWithAuxInterface: To be implemented in the entity that have a oneToMany to aux (Ex: Participant) 
- EntityWithAuxTrait: To be used in the entity that have a oneToMany to aux (Ex: Participant) 

Then in the entity you have a method : getAuxByKey
