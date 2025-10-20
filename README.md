# shell-helpers

Eine Sammlung von nützlichen Shell-Hilfsskripten.

## Installation

### ufw-helper

Der `ufw-helper` ist ein praktisches Tool zum einfachen Verwalten von UFW-Firewall-Regeln für verschiedene Server-Services.

#### Installation mit curl

```bash
# Download und Installation in /usr/local/bin
sudo curl -o /usr/local/bin/ufw-helper https://raw.githubusercontent.com/tualo/shell-helpers/main/ufw-helper

# Ausführbar machen
sudo chmod +x /usr/local/bin/ufw-helper
```

#### Verwendung

Nach der Installation können Sie den `ufw-helper` direkt verwenden:

```bash
# Hilfe anzeigen
ufw-helper --help

# Webserver-Regeln hinzufügen (Port 80, 443)
# Dies ist dann für alle geöffnet
ufw-helper --webserver --comment="meine hinweise"

# SSH-Zugriff für bestimmte IP erlauben
ufw-helper --sshclient=192.168.1.10 --comment="meine hinweise"

# MySQL-Client-Zugriff erlauben
ufw-helper --mysqlclient=192.168.1.20

# Mailserver-Regeln hinzufügen
ufw-helper --mailserver
```

Weitere verfügbare Optionen:
- `--webserver` - HTTP/HTTPS Ports (80, 443)
- `--mailserver` - Mail-Ports (25, 110, 143, 465, 587, 993, 995)
- `--mysqlclient=IP` - MySQL-Zugriff (Port 3306, 3307)
- `--sshclient=IP` - SSH-Zugriff (Port 22)
- `--redisclient=IP` - Redis-Zugriff (Port 6379, 26379)
- `--httpclient=IP` - HTTP/HTTPS Client-Zugriff
- `--clusternode=IP` - Galera Cluster Ports
- `--haproxystat=IP` - HAProxy Statistik Port
- `--clusterchk=IP` - Cluster Check Port
- `--zabbixclient=IP` - Zabbix Monitoring Ports

### slack-cluster-messages

Das `slack-cluster-messages` Script sendet Cluster-Status-Updates an einen Slack-Channel.

#### Installation mit curl

```bash
# Download und Installation in /usr/local/bin
sudo curl -o /usr/local/bin/slack-cluster-messages https://raw.githubusercontent.com/tualo/shell-helpers/main/slack-cluster-messages

# Ausführbar machen
sudo chmod +x /usr/local/bin/slack-cluster-messages
```

#### Konfiguration

Setzen Sie die Slack-Webhook-URL als Umgebungsvariable:

```bash
# Einmalig oder in ~/.bashrc / ~/.zshrc hinzufügen
export SLACK_WEBHOOK_URL='https://hooks.slack.com/services/YOUR/WEBHOOK/URL'
```

#### Verwendung

```bash
# Cluster-Status-Update senden
slack-cluster-messages --status="online" --uuid="cluster-uuid-123" --primary="node1" --index="1" --members="3"

# Beispiel für Cluster-Warnung
slack-cluster-messages --status="warning" --uuid="cluster-uuid-123" --primary="node2" --index="2" --members="2"
```

Parameter:
- `--status` - Status des Clusters (z.B. "online", "warning", "error")
- `--uuid` - Cluster UUID
- `--primary` - Primärer Knoten
- `--index` - Index des Knotens
- `--members` - Anzahl der Cluster-Mitglieder

### mariadb-config-reader

Das `mariadb-config-reader` Script liest MariaDB-Konfigurationsparameter aus, ohne dass eine Datenbankverbindung erforderlich ist.

#### Installation mit curl

```bash
# Download und Installation in /usr/local/bin
sudo curl -o /usr/local/bin/mariadb-config-reader https://raw.githubusercontent.com/tualo/shell-helpers/main/mariadb-config-reader

# Ausführbar machen
sudo chmod +x /usr/local/bin/mariadb-config-reader
```

#### Verwendung

```bash
# Hilfe anzeigen
mariadb-config-reader --help

# Bestimmten Parameter auslesen
mariadb-config-reader -p wsrep_node_name
mariadb-config-reader -p wsrep_cluster_address
mariadb-config-reader -p innodb_buffer_pool_size

# Alle Parameter formatiert anzeigen
mariadb-config-reader --all

# Galera Cluster Informationen anzeigen
mariadb-config-reader --galera
```

Parameter:
- `-p, --parameter=NAME` - Bestimmten Parameter auslesen
- `-a, --all` - Alle Parameter formatiert anzeigen
- `--galera` - Galera Cluster spezifische Informationen
- `-h, --help` - Hilfe anzeigen

Das Script ist besonders nützlich für:
- Automatisierte Scripts die Konfigurationswerte benötigen
- Debugging von MariaDB-Konfigurationen
- Cluster-Management und Monitoring
- CI/CD-Pipelines für Datenbankdeployments

### login-notify

Das `login-notify` Script sendet Benachrichtigungen über SSH-An- und Abmeldungen an einen Slack-Channel. Es wird über PAM (Pluggable Authentication Modules) bei SSH-Logins ausgeführt.

#### Installation mit curl

```bash
# Download und Installation in /etc/ssh/
sudo curl -o /etc/ssh/login-notify https://raw.githubusercontent.com/tualo/shell-helpers/main/login-notify

# Ausführbar machen
sudo chmod +x /etc/ssh/login-notify
```

#### Konfiguration

1. **Umgebungsvariable setzen:**
```bash
# In /etc/environment oder systemweit
export SLACK_WEBHOOK_NOTIFY_URL='https://hooks.slack.com/services/YOUR/WEBHOOK/URL'
```

2. **PAM konfigurieren:**
Fügen Sie diese Zeile in `/etc/pam.d/sshd` hinzu:
```bash
# Am Ende der Datei hinzufügen
session optional pam_exec.so seteuid /etc/ssh/login-notify
```

#### Funktionalität

Das Script:
- Erfasst SSH-Login-Ereignisse automatisch
- Sendet Benachrichtigungen mit Benutzername, IP-Adresse und Hostname
- Integriert Galera Cluster-Informationen (falls verfügbar)
- Verwendet PAM-Umgebungsvariablen (`$PAM_USER`, `$PAM_RHOST`)

#### Beispiel-Benachrichtigung
```
SSH Login: admin from 192.168.1.100 Node Name: cluster01 on webserver01
```

Das Script ist ideal für:
- Sicherheitsmonitoring von SSH-Zugriffen
- Tracking von Administrator-Logins
- Cluster-Node Überwachung
- Compliance und Audit-Anforderungen
