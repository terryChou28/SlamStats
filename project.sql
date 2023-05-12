DROP TABLE Teams_City;
DROP TABLE Playoffs_Standings;
DROP TABLE Season_Standings;
DROP TABLE Regular_Season_Statistics;
DROP TABLE Playoffs_Statistics;
DROP TABLE Play;
DROP TABLE Games_Play_In_Stadium;
DROP TABLE Stadium;
DROP TABLE Coaches;
DROP TABLE Players_Play_For;
DROP TABLE Teams;

CREATE TABLE Teams (
  tid INTEGER PRIMARY KEY,
  tname CHAR(20) UNIQUE NOT NULL,
  division CHAR(20) NOT NULL
);

grant select on Teams to public;

CREATE TABLE Teams_City (
  cname CHAR(20) NOT NULL,
  tid INTEGER PRIMARY KEY,
  FOREIGN KEY (tid) REFERENCES Teams(tid) ON DELETE CASCADE
);

grant select on Teams_City to public;

CREATE TABLE Playoffs_Standings (
    sid INTEGER NOT NULL,
    ranking INTEGER,
    wins INTEGER,
    losses INTEGER,
    seeds INTEGER,
    round INTEGER,
    tid INTEGER NOT NULL,
    PRIMARY KEY(sid, tid),
    FOREIGN KEY(tid) REFERENCES Teams(tid) ON DELETE CASCADE
    );

grant select on Playoffs_Standings to public;

CREATE TABLE Season_Standings (
  sid INTEGER,
  ranking INTEGER,
  wins INTEGER,
  losses INTEGER,
  conference_records INTEGER,
  tid INTEGER NOT NULL,
  PRIMARY KEY(sid, tid),
  FOREIGN KEY(tid) REFERENCES Teams(tid) ON DELETE CASCADE
);

grant select on Season_Standings to public;

CREATE TABLE Stadium (
  sname CHAR(30) PRIMARY KEY,
  tid INTEGER UNIQUE,
  capacity INTEGER,
  FOREIGN KEY(tid) REFERENCES Teams(tid) ON DELETE CASCADE
);

grant select on Stadium to public;

CREATE TABLE Games_Play_In_Stadium (
  gid INTEGER,
  score CHAR(20),
  g_date date,
  g_time CHAR(20),
  home_team CHAR(20),
  away_team CHAR(20),
  sname CHAR(30),
  PRIMARY KEY(gid),
  CONSTRAINT date_home_team_away_team UNIQUE (g_date, home_team, away_team),
  FOREIGN KEY(sname) REFERENCES Stadium(sname) ON DELETE CASCADE
);

grant select on Games_Play_In_Stadium to public;

CREATE TABLE Play (
  tid INTEGER,
  gid INTEGER,
  PRIMARY KEY(tid, gid),
  FOREIGN KEY(tid) REFERENCES Teams(tid) ON DELETE CASCADE,
  FOREIGN KEY(gid) REFERENCES Games_Play_In_Stadium(gid) ON DELETE CASCADE
);

grant select on Play to public;

CREATE TABLE Coaches
(
  cid        INTEGER PRIMARY KEY,
  experience CHAR(20),
  cname      CHAR(20),
  salary     INTEGER,
  tid        INTEGER UNIQUE,
  FOREIGN KEY (tid) REFERENCES Teams (tid) ON DELETE CASCADE
);

grant select on Coaches to public;

CREATE TABLE Players_Play_For
(
  pid      INTEGER PRIMARY KEY,
  salary   INTEGER,
  pname    CHAR(20),
  pnumber   INTEGER,
  height   CHAR(7),
  position CHAR(20),
  tid      INTEGER,
  FOREIGN KEY (tid) REFERENCES Teams (tid) ON DELETE CASCADE
);

grant select on Players_Play_For to public;

CREATE TABLE Regular_Season_Statistics (
  statid INTEGER PRIMARY KEY,
  season_points INTEGER,
  pid INTEGER UNIQUE,
  FOREIGN KEY (pid) REFERENCES Players_Play_For(pid) ON DELETE CASCADE
);

grant select on Regular_Season_Statistics to public;

CREATE TABLE Playoffs_Statistics (
  statid INTEGER PRIMARY KEY,
  playoff_points INTEGER,
  pid INTEGER UNIQUE,
  FOREIGN KEY (pid) REFERENCES Players_Play_For(pid) ON DELETE CASCADE
);

grant select on Playoffs_Statistics to public;

-- Insert data into Teams table
INSERT INTO Teams (tid, tname, division)
VALUES (1, 'Lakers', 'Pacific');

INSERT INTO Teams (tid, tname, division)
VALUES (2, 'Celtics', 'Atlantic');

INSERT INTO Teams (tid, tname, division)
VALUES (3, 'Rockets', 'Southwest');

INSERT INTO Teams (tid, tname, division)
VALUES (4, 'Heat', 'Southeast');

INSERT INTO Teams (tid, tname, division)
VALUES (5, 'Warriors', 'Pacific');

-- Insert data into Teams_City table
INSERT INTO Teams_City (tid, cname)
VALUES (1, 'Los Angeles');

INSERT INTO Teams_City (tid, cname)
VALUES (2, 'Boston');

INSERT INTO Teams_City (tid, cname)
VALUES (3, 'Houston');

INSERT INTO Teams_City (tid, cname)
VALUES (4, 'Miami');

INSERT INTO Teams_City (tid, cname)
VALUES (5, 'San Francisco');

-- Insert data into Playoffs_Standings table
INSERT INTO Playoffs_Standings (sid, ranking, wins, losses, seeds, round, tid)
VALUES (1, 1, 16, 5, 1, 4, 1);

INSERT INTO Playoffs_Standings (sid, ranking, wins, losses, seeds, round, tid)
VALUES (1, 2, 14, 6, 2, 4, 2);

INSERT INTO Playoffs_Standings (sid, ranking, wins, losses, seeds, round, tid)
VALUES (1, 3, 12, 7, 3, 3, 3);

INSERT INTO Playoffs_Standings (sid, ranking, wins, losses, seeds, round, tid)
VALUES (1, 4, 11, 8, 4, 3, 4);

INSERT INTO Playoffs_Standings (sid, ranking, wins, losses, seeds, round, tid)
VALUES (1, 5, 10, 9, 5, 2, 5);

-- Insert data into Season_Standings table
INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (1, 1, 52, 20, 32, 1);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (1, 2, 48, 24, 31, 2);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (1, 3, 46, 26, 27, 3);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (1, 4, 44, 28, 25, 4);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (1, 5, 39, 33, 22, 5);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (2, 1, 55, 17, 35, 3);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (2, 2, 50, 22, 31, 1);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (2, 3, 48, 24, 28, 2);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (2, 4, 45, 27, 27, 5);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (2, 5, 41, 31, 23, 4);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (3, 1, 54, 18, 36, 2);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (3, 2, 49, 23, 31, 1);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (3, 3, 47, 25, 29, 4);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (3, 4, 44, 28, 27, 5);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (3, 5, 40, 32, 25, 3);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (4, 1, 57, 13, 38, 1);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (4, 2, 53, 17, 33, 2);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (4, 3, 49, 21, 30, 4);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (4, 4, 46, 24, 28, 5);

INSERT INTO Season_Standings (sid, ranking, wins, losses, conference_records, tid)
VALUES (4, 5, 42, 28, 26, 3);

INSERT INTO Stadium (sname, tid, capacity) VALUES ('Staples Center', 1, 19060);
INSERT INTO Stadium (sname, tid, capacity) VALUES ('TD Garden', 2, 19580);
INSERT INTO Stadium (sname, tid, capacity) VALUES ('Toyota Center', 3, 18055);
INSERT INTO Stadium (sname, tid, capacity) VALUES ('American Airlines Arena', 4, 19600);
INSERT INTO Stadium (sname, tid, capacity) VALUES ('Chase Center', 5, 18064);

INSERT INTO Games_Play_In_Stadium (gid, score, g_date, g_time, home_team, away_team, sname)
VALUES (1, '105-99', TO_DATE('2022-10-19', 'YYYY-MM-DD'), TO_DATE('19:30:00', 'HH24:MI:SS'), 'Lakers', 'Clippers', 'Staples Center');
INSERT INTO Games_Play_In_Stadium (gid, score, g_date, g_time, home_team, away_team, sname)
VALUES (2, '120-112', TO_DATE('2022-10-19', 'YYYY-MM-DD'), TO_DATE('19:30:00', 'HH24:MI:SS'), 'Celtics', 'Nets', 'TD Garden');
INSERT INTO Games_Play_In_Stadium (gid, score, g_date, g_time, home_team, away_team, sname)
VALUES (3, '128-120', TO_DATE('2022-10-20', 'YYYY-MM-DD'), TO_DATE('19:30:00', 'HH24:MI:SS'), 'Lakers', 'Warriors', 'Staples Center');
INSERT INTO Games_Play_In_Stadium (gid, score, g_date, g_time, home_team, away_team, sname)
VALUES (4, '118-109', TO_DATE('2022-10-20', 'YYYY-MM-DD'), TO_DATE('20:00:00', 'HH24:MI:SS'), 'Celtics', 'Bucks', 'TD Garden');
INSERT INTO Games_Play_In_Stadium (gid, score, g_date, g_time, home_team, away_team, sname)
VALUES (5, '115-108', TO_DATE('2022-10-21', 'YYYY-MM-DD'), TO_DATE('19:00:00', 'HH24:MI:SS'), 'Rockets', 'Spurs', 'Toyota Center');
INSERT INTO Games_Play_In_Stadium (gid, score, g_date, g_time, home_team, away_team, sname)
VALUES (6, '100-92', TO_DATE('2022-10-22', 'YYYY-MM-DD'), TO_DATE('19:00:00', 'HH24:MI:SS'), 'Heat', 'Celtics', 'American Airlines Arena');
INSERT INTO Games_Play_In_Stadium (gid, score, g_date, g_time, home_team, away_team, sname)
VALUES (7, '110-105', TO_DATE('2022-10-23', 'YYYY-MM-DD'), TO_DATE('20:00:00', 'HH24:MI:SS'), 'Rockets', 'Jazz', 'Toyota Center');
INSERT INTO Games_Play_In_Stadium (gid, score, g_date, g_time, home_team, away_team, sname)
VALUES (8, '95-89', TO_DATE('2022-10-24', 'YYYY-MM-DD'), TO_DATE('19:00:00', 'HH24:MI:SS'), 'Heat', 'Bulls', 'American Airlines Arena');
INSERT INTO Games_Play_In_Stadium (gid, score, g_date, g_time, home_team, away_team, sname)
VALUES (9, '115-110', TO_DATE('2022-10-25', 'YYYY-MM-DD'), TO_DATE('19:30:00', 'HH24:MI:SS'), 'Warriors', 'Suns', 'Chase Center');
INSERT INTO Games_Play_In_Stadium (gid, score, g_date, g_time, home_team, away_team, sname)
VALUES (10, '105-100', TO_DATE('2022-10-25', 'YYYY-MM-DD'), TO_DATE('20:00:00', 'HH24:MI:SS'), 'Heat', 'Knicks', 'American Airlines Arena');

INSERT INTO Coaches (cid, experience, cname, salary, tid) VALUES (1, '10 years', 'Frank Vogel', 5000000, 1);
INSERT INTO Coaches (cid, experience, cname, salary, tid) VALUES (2, '5 years', 'Brad Stevens', 7000000, 2);
INSERT INTO Coaches (cid, experience, cname, salary, tid) VALUES (3, '8 years', 'Stephen Silas', 4000000, 3);
INSERT INTO Coaches (cid, experience, cname, salary, tid) VALUES (4, '3 years', 'Erik Spoelstra', 6500000, 4);
INSERT INTO Coaches (cid, experience, cname, salary, tid) VALUES (5, '6 years', 'Steve Kerr', 10000000, 5);

-- Insert data into Players_Play_For table
INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (1, 2000000, 'LeBron James', 23, '6''9"', 'SF', 1);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (2, 1500000, 'Anthony Davis', 3, '6''10"', 'PF', 1);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (3, 1200000, 'Russell Westbrook', 0, '6''3"', 'PG', 1);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (4, 800000, 'Dennis Schroder', 17, '6''1"', 'PG', 1);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (5, 2000000, 'Jayson Tatum', 0, '6''8"', 'SF', 2);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (6, 1800000, 'Jaylen Brown', 7, '6''6"', 'SG', 2);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (7, 1000000, 'Marcus Smart', 36, '6''3"', 'PG', 2);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (8, 800000, 'Grant Williams', 12, '6''6"', 'PF', 2);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (9, 1000000, 'Christian Wood', 35, '6''10"', 'PF', 3);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (10, 800000, 'Eric Gordon', 10, '6''3"', 'SG', 3);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (11, 1500000, 'Jimmy Butler', 22, '6''7"', 'SF', 4);

INSERT INTO Players_Play_For (pid, salary, pname, pnumber, height, position, tid)
VALUES (12, 900000, 'Bam Adebayo', 25, '6''8"', 'SG', 4);

-- Insert data into Play table
INSERT INTO Play (tid, gid) VALUES (1, 1);
INSERT INTO Play (tid, gid) VALUES (1, 3);
INSERT INTO Play (tid, gid) VALUES (2, 2);
INSERT INTO Play (tid, gid) VALUES (2, 4);
INSERT INTO Play (tid, gid) VALUES (3, 5);
INSERT INTO Play (tid, gid) VALUES (3, 7);
INSERT INTO Play (tid, gid) VALUES (4, 6);
INSERT INTO Play (tid, gid) VALUES (4, 8);
INSERT INTO Play (tid, gid) VALUES (5, 9);
INSERT INTO Play (tid, gid) VALUES (5, 10);

INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (1, 2000, 1);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (2, 1500, 2);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (3, 1200, 3);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (4, 800, 4);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (5, 2000, 5);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (6, 1800, 6);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (7, 1000, 7);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (8, 800, 8);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (9, 1000, 9);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (10, 800, 10);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (11, 1500, 11);
INSERT INTO Regular_Season_Statistics (statid, season_points, pid)
VALUES (12, 900, 12);

INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (1, 500, 1);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (2, 400, 2);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (3, 300, 3);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (4, 200, 4);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (5, 500, 5);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (6, 400, 6);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (7, 300, 7);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (8, 200, 8);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (9, 300, 9);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (10, 200, 10);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (11, 400, 11);
INSERT INTO Playoffs_Statistics (statid, playoff_points, pid)
VALUES (12, 250, 12);