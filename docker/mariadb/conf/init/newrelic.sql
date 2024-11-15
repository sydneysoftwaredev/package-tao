# Create 'newrelic' user
CREATE USER 'newrelic' IDENTIFIED BY 'newrelicsecret';

# Grant replication client privileges
GRANT REPLICATION CLIENT ON *.* TO 'newrelic';

# Grant select privileges
GRANT
SELECT
    ON *.* TO 'newrelic';