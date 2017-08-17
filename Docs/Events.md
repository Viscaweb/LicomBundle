## Events

### List of events:

Listen by...

| ``↓ Object`` - ``Scope →``          | Match | Competition | CompetitionSeasonStage | CompetitionRound | CompetitionStage | CompetitionLeg | Team | Athlete | Sport | Match Start Date  |
| :---------------------------------  | :---: | :---------: | :--------------------: | :--------------: | :--------------: | :------------: | :--: | :-----: | :---: | :---------------: |
| Match                               | ✓     | ✓           | ✓                      |                  |                  |                | ✓    |         |       | ✓                 |
| → MatchHasBegun                     | ✓     | ✓           | ✓                      |                  |                  |                | ✓    |         | ✓     |                   |
| → MatchHasFinished                  | ✓     | ✓           | ✓                      |                  |                  |                | ✓    |         | ✓     |                   |
| → MatchRefereeAssigned              | ✓     |             |                        |                  |                  |                |      |         |       |                   |
| MatchResult                         | ✓     | ✓           |                        |                  |                  |                | ✓    |         |       | ✓                 |
| MatchIncident                       | ✓     | ✓           |                        |                  |                  |                | ✓    | ✓       |       | ✓                 |
| → MatchIncidentCard                 | ✓     | ✓           |                        |                  |                  |                | ✓    | ✓       |       | ✓                 |
| → MatchIncidentAssist               | ✓     |             |                        |                  |                  |                | ✓    | ✓       |       |                   |
| → MatchIncidentSubstitution         | ✓     |             |                        |                  |                  |                | ✓    | ✓       |       |                   |
| → MatchIncidentRegularGoal          | ✓     |             |                        |                  |                  |                | ✓    | ✓       |       |                   |
| → MatchIncidentRegularPenaltyScored | ✓     |             |                        |                  |                  |                | ✓    | ✓       |       |                   |
| → MatchIncidentRegularPenaltyMissed | ✓     |             |                        |                  |                  |                | ✓    | ✓       |       |                   |
| → MatchIncidentOwnGoal              | ✓     |             |                        |                  |                  |                | ✓    | ✓       |       |                   |
| MatchComment                        | ✓     |             |                        |                  |                  |                |      |         |       |                   |
| MatchStats                          | ✓     | ✓           |                        |                  |                  |                | ✓    |         |       |                   |
| MatchLineup                         | ✓     | ✓           |                        |                  |                  |                | ✓    | ✓       |       |                   |
| Competition                         |       | ✓           |                        |                  |                  |                |      |         |       |                   |
| CompetitionLeg                      |       | ✓           |                        |                  |                  | ✓              |      |         |       |                   |
| CompetitionRound                    |       | ✓           |                        | ✓                |                  |                |      |         |       |                   |
| CompetitionSeasonStage              |       | ✓           | ✓                      |                  |                  |                |      |         |       |                   |
| CompetitionStage                    |       | ✓           |                        |                  | ✓                |                |      |         |       |                   |
| Participant                         |       |             |                        |                  |                  |                |      |         | ✓     |                   |
| Odds                                | ✓     |             |                        |                  |                  |                |      |         |       |                   |
| → OddsThreeWay                      | ✓     |             |                        |                  |                  |                |      |         |       |                   |
| → OddsOverUnder                     | ✓     |             |                        |                  |                  |                |      |         |       |                   |
| Standings                           |       | ✓           | ✓                      |                  |                  |                |      |         |       |                   |