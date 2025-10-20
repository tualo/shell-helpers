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
