"""Catalogue des sections : ce que fait chaque section et ce dont elle a besoin pour être vraie.

Toutes les sections servent à tous les métiers. Le catalogue sert à composer le site d'un client
section par section : on part des questions de ses visiteurs (parcours.json), puis on choisit ici
les sections qui y répondent avec ce que le client peut réellement fournir (photos, prix, avis…).

Écrit catalogue-sections.md à partir de build/br_sections.json (après node build_br_sections.js).
"""
import json
import pathlib
import re

ICI = pathlib.Path(__file__).parent
S = json.load(open(ICI / 'build' / 'br_sections.json'))

FAMILLES = {
    'ouverture': 'Ouverture (haut de l’accueil ou d’une page)',
    'offre': 'Offre et tarifs',
    'confiance': 'Confiance et preuves',
    'parcours': 'Parcours et questions',
    'personnes': 'Personnes',
    'contenu': 'Contenu',
    'contact': 'Contact et conversion',
}

# Ce que la section va chercher dans le site : à remplir avant de la choisir.
DONNEES = [
    (r'\[briise_realisations', 'fiches Réalisations publiées'),
    (r'\[briise_zone_plan', 'communes avec coordonnées (Mon entreprise > Entreprise) ; plan fabriqué à l’enregistrement'),
    (r'\[briise_zone(_liste)?\b', 'communes avec coordonnées (Mon entreprise > Entreprise)'),
    (r'\[briise_carte_zone', 'communes et rayon (Mon entreprise)'),
    (r'\[briise_qualifications', 'qualifications et assurances (Mon entreprise > Entreprise)'),
    (r'\[briise_horaires', 'horaires (Mon entreprise)'),
    (r'\[briise_disponibilite', 'prochaine date libre (Horaires et annonces)'),
    (r'\[briise_formulaire type="devis"', 'formulaire de devis (Fluent Forms)'),
    (r'\[briise_formulaire type="contact"', 'formulaire de contact (Fluent Forms)'),
    (r'\[briise_formulaire type="reservation"', 'formulaire de réservation (Fluent Forms)'),
    (r'\[briise_formulaire type="rappel"', 'formulaire de rappel (Fluent Forms)'),
    (r'\[briise_pages_liees', 'pages enfants (services)'),
    (r'\[briise_(coordonnees|carte_coordonnees)', 'adresse, téléphone, e-mail (Mon entreprise)'),
]
# Ce que le client doit fournir, vrai et vérifiable.
CONTENUS = [
    (r'br-avis|wp-block-quote|ETOILES|★', 'avis réels, avec l’accord de leur auteur (jamais pour une profession réglementée)'),
    (r'€', 'prix réels'),
    (r'br-tuile-chiffre|br-equipe-chiffre|br-chiffres|br-stat', 'chiffres vérifiables'),
    (r'wp-block-file|br-doc', 'documents PDF à jour'),
    (r'logo-\d', 'logos de clients, avec leur accord'),
]
# Comportement ajouté par le navigateur, et ce qui reste sans script.
SCRIPT = [
    ('br-defile', 'défile (pause, immobile si moins d’animations) ; sans script : bande fixe'),
    ('br-faq-cherche', 'recherche et thèmes ; sans script : FAQ complète'),
    ('br-oriente', 'menus « Je cherche … pour … » ; sans script : liste de liens'),
    ('br-estim', 'calcul de la fourchette ; sans script : barème en tableau'),
    ('etapes="1"', 'formulaire en trois étapes ; sans script : formulaire complet'),
    ('br-glisse', 'curseur avant / après ; sans script : deux photos'),
    ('br-galerie-agrandir|br-agrandir', 'agrandissement plein écran ; sans script : photos simples'),
]


def ligne(slug, s):
    m = s['markup']
    photos = len(set(re.findall(r'\{\{IMG:([^}]+)\}\}', m)))
    besoins = []
    if photos:
        besoins.append(f'{photos} photo{"s" if photos > 1 else ""}')
    besoins += [t for r, t in CONTENUS if re.search(r, m)]
    besoins += sorted({t for r, t in DONNEES if re.search(r, m)})
    if '{{SERVICE:' in m:
        besoins.append('pages de service')
    script = '; '.join(t for c, t in SCRIPT if re.search(c, m))
    return f"| `{slug}` | {s['title']} | {s['desc']} | {', '.join(besoins) or '—'} | {script or '—'} |"


sortie = [
    '# Catalogue des sections Briise',
    '',
    'Fichier produit par `catalogue.py` : ne pas le modifier à la main.',
    '',
    'Toutes les sections servent à tous les métiers. Pour composer un site : partir des questions que se posent ses visiteurs (`parcours.json`, une grille de réflexion, pas un kit), choisir ici les sections qui y répondent avec ce que le client peut réellement fournir, varier les ouvertures et les habillages d’un site à l’autre (`variantes.json`, `registre.py`), puis assembler le fichier de site (`build_br_sections.js`, `rythme()` de `build_br_kits.js`, `validate.js`).',
    '',
    'Colonne « Besoins » : ce qu’il faut avoir avant de choisir la section. Une section sans son contenu réel ne doit pas être publiée.',
    '',
]
for fam, nom in FAMILLES.items():
    items = sorted((k, v) for k, v in S.items() if v['cat'] == fam)
    if not items:
        continue
    sortie += [f'## {nom} ({len(items)})', '', '| Section | Titre | À quoi elle sert | Besoins | Dans le navigateur |', '| --- | --- | --- | --- | --- |']
    sortie += [ligne(k, v) for k, v in items]
    sortie.append('')
(ICI / 'catalogue-sections.md').write_text('\n'.join(sortie))
print(f'  catalogue : {len(S)} sections')
