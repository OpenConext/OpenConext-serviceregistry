-- Profiling / doctrine test, convert created to a proper datetime field
ALTER TABLE `janus__entity` CHANGE COLUMN `created` `created` DATETIME DEFAULT NULL;