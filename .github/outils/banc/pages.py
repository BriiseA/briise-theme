"""Vérifie chaque page du site de test (en ligne, sans erreur, un seul titre principal)
et les protections de sécurité vues de l'extérieur."""
import os
import re
import sys
import urllib.error
import urllib.request

URL = os.environ['BANC_URL']
SORTIE = os.environ['BANC_SORTIE']
WP = os.environ['BANC_WP']
echecs = []


class SansRedirection(urllib.request.HTTPRedirectHandler):
    def redirect_request(self, *args, **kwargs):
        return None


direct = urllib.request.build_opener(SansRedirection)


def lire(url, methode='GET', donnees=None):
    req = urllib.request.Request(url, data=donnees, method=methode)
    try:
        r = direct.open(req, timeout=60)
        return r.status, dict(r.headers), r.read().decode('utf-8', 'replace')
    except urllib.error.HTTPError as e:
        return e.code, dict(e.headers), e.read().decode('utf-8', 'replace')


def ok(cond, msg):
    print(('  ok     ' if cond else '  ÉCHEC  ') + msg)
    if not cond:
        echecs.append(msg)


adresses = [a for a in open(os.path.join(SORTIE, 'adresses.txt')).read().split() if a]
mauvaises = []
for a in adresses:
    code, _, html = lire(a)
    soucis = []
    if code != 200:
        soucis.append(f'code {code}')
    if '[briise_' in html:
        soucis.append('code court non remplacé')
    if re.search(r'(Fatal error|Warning|Notice|Deprecated)</b>:', html):
        soucis.append('erreur PHP affichée')
    h1 = len(re.findall(r'<h1[\s>]', html))
    if h1 != 1:
        soucis.append(f'{h1} titres principaux')
    if soucis:
        mauvaises.append(a.replace(URL, '') + ' : ' + ', '.join(soucis))
ok(not mauvaises, f'{len(adresses)} pages en ligne, sans erreur, un seul titre principal' + ('\n           ' + '\n           '.join(mauvaises) if mauvaises else ''))

code, entetes, _ = lire(URL + '/')
entetes = {k.lower(): v for k, v in entetes.items()}
for e in ('x-content-type-options', 'x-frame-options', 'referrer-policy', 'permissions-policy'):
    ok(e in entetes, f'en-tête de sécurité {e}')
code, _, _ = lire(URL + '/xmlrpc.php', 'POST', b'<x/>')
ok(code == 403, f'XML-RPC fermé (code {code})')
code, entetes, _ = lire(URL + '/?author=1')
ok(code == 301 and 'author' not in entetes.get('Location', entetes.get('location', '')), f'identifiant caché derrière ?author=1 (code {code})')
code, _, _ = lire(URL + '/wp-json/wp/v2/users')
ok(code == 404, f'liste des utilisateurs fermée aux visiteurs (code {code})')

journal = os.path.join(WP, 'wp-content', 'debug.log')
if os.path.exists(journal):
    lignes = [l for l in open(journal, errors='replace') if ('briise' in l.lower()) and ('PHP' in l)]
    ok(not lignes, 'aucune erreur PHP du thème ou de l’extension' + ('\n           ' + '\n           '.join(l.strip()[:220] for l in lignes[:8]) if lignes else ''))

sys.exit(1 if echecs else 0)
