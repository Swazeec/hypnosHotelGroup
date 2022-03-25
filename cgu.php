<?php
session_start();
require_once('./components/db/db.php');
if(isset($_SESSION['connect'])){
    if($_SESSION['connect'] == 'client'){
        require_once('./components/header/header-client.php');
    } else if ($_SESSION['connect'] == 'pro'){
        require_once('./components/header/header-pro.php');
    } else {
        require_once('./components/header/header-noauth.php');
    }
} else {
    require_once('./components/header/header-noauth.php');
}
?>
<section class="row  px-lg-5 mt-5">
Conditions générales d'utilisation

En vigueur au 24/03/2022
 

Les présentes conditions générales d'utilisation (dites « CGU ») ont pour objet l'encadrement juridique des modalités de mise à disposition du site et des services par Hypnos Hotel Group  et de définir les conditions d’accès et d’utilisation des services par « l'Utilisateur ».
Les présentes CGU sont accessibles sur le site à la rubrique «CGU».

Toute inscription ou utilisation du site implique l'acceptation sans aucune réserve ni restriction des présentes CGU par l’utilisateur. Lors de l'inscription sur le site via le Formulaire d’inscription, chaque utilisateur accepte expressément les présentes CGU en cochant la case précédant le texte suivant : « Je reconnais avoir lu et compris les CGU et je les accepte ».
En cas de non-acceptation des CGU stipulées dans le présent contrat, l'Utilisateur se doit de renoncer à l'accès des services proposés par le site.
https://morning-thicket-60280.herokuapp.com/  se réserve le droit de modifier unilatéralement et à tout moment le contenu des présentes CGU.

Article 1 : Les mentions légales

L'édition du site https://morning-thicket-60280.herokuapp.com/ est assurée par la Société SARL Hypnos Hotel Group au capital de 2000000000 euros, immatriculée au RCS de Rennes sous le numéro 15662965958498168, dont le siège social est situé au 35 rue de quelque part
Numéro de téléphone 06********
Adresse e-mail : hhypnos@groups.com.
Le Directeur de la publication est : Juste Moi

L'hébergeur du site https://morning-thicket-60280.herokuapp.com/ est la société Heroku, dont le siège social est situé au SARL, avec le numéro de téléphone : 7137053210.

ARTICLE 2 : Accès au site

Le site https://morning-thicket-60280.herokuapp.com/  permet à l'Utilisateur un accès gratuit aux services suivants :
Le site internet propose les services suivants :
Réservation et gestion en ligne de réservation de chambre d'hôtel
Le site est accessible gratuitement en tout lieu à tout Utilisateur ayant un accès à Internet. Tous les frais supportés par l'Utilisateur pour accéder au service (matériel informatique, logiciels, connexion Internet, etc.) sont à sa charge.

L’Utilisateur non membre n'a pas accès aux services réservés. Pour cela, il doit s’inscrire en remplissant le formulaire. En acceptant de s’inscrire aux services réservés, l’Utilisateur membre s’engage à fournir des informations sincères et exactes concernant son état civil et ses coordonnées, notamment son adresse email.
Pour accéder aux services, l’Utilisateur doit ensuite s'identifier à l'aide de son identifiant et de son mot de passe qui lui seront communiqués après son inscription.
Tout Utilisateur membre régulièrement inscrit pourra également solliciter sa désinscription en se rendant à la page dédiée sur son espace personnel. Celle-ci sera effective dans un délai raisonnable.
Tout événement dû à un cas de force majeure ayant pour conséquence un dysfonctionnement du site ou serveur et sous réserve de toute interruption ou modification en cas de maintenance, n'engage pas la responsabilité de https://morning-thicket-60280.herokuapp.com/. Dans ces cas, l’Utilisateur accepte ainsi ne pas tenir rigueur à l’éditeur de toute interruption ou suspension de service, même sans préavis.
L'Utilisateur a la possibilité de contacter le site par messagerie électronique à l’adresse email de l’éditeur communiqué à l’ARTICLE 1.

ARTICLE 3 : Collecte des données

Le site assure à l'Utilisateur une collecte et un traitement d'informations personnelles dans le respect de la vie privée conformément à la loi n°78-17 du 6 janvier 1978 relative à l'informatique, aux fichiers et aux libertés. Le site est déclaré à la CNIL sous le numéro 3151351235132156.
En vertu de la loi Informatique et Libertés, en date du 6 janvier 1978, l'Utilisateur dispose d'un droit d'accès, de rectification, de suppression et d'opposition de ses données personnelles. L'Utilisateur exerce ce droit :
·         par mail à l'adresse email RGPD@hypnosgroup.com
·         via un formulaire de contact ;
 

ARTICLE 4 : Propriété intellectuelle

Les marques, logos, signes ainsi que tous les contenus du site (textes, images, son…) font l'objet d'une protection par le Code de la propriété intellectuelle et plus particulièrement par le droit d'auteur.

La marque Hypnos Hotel Group est une marque déposée par Hypnos Hotel.Toute représentation et/ou reproduction et/ou exploitation partielle ou totale de cette marque, de quelque nature que ce soit, est totalement prohibée.

L'Utilisateur doit solliciter l'autorisation préalable du site pour toute reproduction, publication, copie des différents contenus. Il s'engage à une utilisation des contenus du site dans un cadre strictement privé, toute utilisation à des fins commerciales et publicitaires est strictement interdite.
Toute représentation totale ou partielle de ce site par quelque procédé que ce soit, sans l’autorisation expresse de l’exploitant du site Internet constituerait une contrefaçon sanctionnée par l’article L 335-2 et suivants du Code de la propriété intellectuelle.
Il est rappelé conformément à l’article L122-5 du Code de propriété intellectuelle que l’Utilisateur qui reproduit, copie ou publie le contenu protégé doit citer l’auteur et sa source.
 
ARTICLE 5 : Responsabilité

Les sources des informations diffusées sur le site https://morning-thicket-60280.herokuapp.com/ sont réputées fiables mais le site ne garantit pas qu’il soit exempt de défauts, d’erreurs ou d’omissions.
Les informations communiquées sont présentées à titre indicatif et général sans valeur contractuelle. Malgré des mises à jour régulières, le site https://morning-thicket-60280.herokuapp.com/ ne peut être tenu responsable de la modification des dispositions administratives et juridiques survenant après la publication. De même, le site ne peut être tenue responsable de l’utilisation et de l’interprétation de l’information contenue dans ce site.
L'Utilisateur s'assure de garder son mot de passe secret. Toute divulgation du mot de passe, quelle que soit sa forme, est interdite. Il assume les risques liés à l'utilisation de son identifiant et mot de passe. Le site décline toute responsabilité.
Le site https://morning-thicket-60280.herokuapp.com/ ne peut être tenu pour responsable d’éventuels virus qui pourraient infecter l’ordinateur ou tout matériel informatique de l’Internaute, suite à une utilisation, à l’accès, ou au téléchargement provenant de ce site.
La responsabilité du site ne peut être engagée en cas de force majeure ou du fait imprévisible et insurmontable d'un tiers.

ARTICLE 6 : Liens hypertextes

Des liens hypertextes peuvent être présents sur le site. L’Utilisateur est informé qu’en cliquant sur ces liens, il sortira du site https://morning-thicket-60280.herokuapp.com/. Ce dernier n’a pas de contrôle sur les pages web sur lesquelles aboutissent ces liens et ne saurait, en aucun cas, être responsable de leur contenu.

ARTICLE 7 : Cookies

L’Utilisateur est informé que lors de ses visites sur le site, un cookie peut s’installer automatiquement sur son logiciel de navigation.
Les cookies sont de petits fichiers stockés temporairement sur le disque dur de l’ordinateur de l’Utilisateur par votre navigateur et qui sont nécessaires à l’utilisation du site https://morning-thicket-60280.herokuapp.com/. Les cookies ne contiennent pas d’information personnelle et ne peuvent pas être utilisés pour identifier quelqu’un. Un cookie contient un identifiant unique, généré aléatoirement et donc anonyme. Certains cookies expirent à la fin de la visite de l’Utilisateur, d’autres restent.
L’information contenue dans les cookies est utilisée pour améliorer le site https://morning-thicket-60280.herokuapp.com/.
En naviguant sur le site, L’Utilisateur les accepte.
L’Utilisateur doit toutefois donner son consentement quant à l’utilisation de certains cookies.
A défaut d’acceptation, l’Utilisateur est informé que certaines fonctionnalités ou pages risquent de lui être refusées.
L’Utilisateur pourra désactiver ces cookies par l’intermédiaire des paramètres figurant au sein de son logiciel de navigation.

ARTICLE 8 : Droit applicable et juridiction compétente

La législation française s'applique au présent contrat. En cas d'absence de résolution amiable d'un litige né entre les parties, les tribunaux français seront seuls compétents pour en connaître.
Pour toute question relative à l’application des présentes CGU, vous pouvez joindre l’éditeur aux coordonnées inscrites à l’ARTICLE 1.
</section>
<?php
require_once('./components/footer.php');
?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>