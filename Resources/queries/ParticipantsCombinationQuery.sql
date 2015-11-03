SELECT
  TranslationTeamHome.entityId AS homeParticipantID,
  TranslationTeamAway.entityId AS awayParticipantID

FROM
  (ProfileTranslation_graph AssociationTranslationTeamHome,
  ProfileTranslation_graph AssociationTranslationTeamAway)

LEFT JOIN LocalizationTranslation TranslationTeamHome
ON TranslationTeamHome.id = AssociationTranslationTeamHome.LocalizationTranslation

LEFT JOIN LocalizationTranslation TranslationTeamAway
ON TranslationTeamAway.id = AssociationTranslationTeamAway.LocalizationTranslation

WHERE
  AssociationTranslationTeamHome.label = :profileTranslationLabel AND
  AssociationTranslationTeamAway.label = :profileTranslationLabel AND

  AssociationTranslationTeamHome.Profile = :profileId AND
  AssociationTranslationTeamAway.Profile = :profileId AND

  TranslationTeamHome.LocalizationTranslationType = :localizationTranslationType AND
  TranslationTeamAway.LocalizationTranslationType = :localizationTranslationType AND

  BINARY CONCAT(TranslationTeamHome.text, '-', TranslationTeamAway.text) = :matchSlug;