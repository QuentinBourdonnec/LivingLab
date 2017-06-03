README du LivingLab

Veuillez effectuer ces installations au préalable (librairies et applications) sur votre système d'exploitation linux 16.04 
grâce aux commandes suivantes :

# sudo apt-get update                                                //Pour mettre à jour la liste des fichiers disponibles dans les dépôts APT
# sudo apt-get install mysql-server                                  //Installation de mysql (choisir un mot de passe de votre choix)
# sudo apt-get install phpmyadmin                                    //Installation de phpmyadmin ('espace' sur apache2, 'ctrl' puis 'entree')
# sudo apt-get install libmysqlcppconn-dev                           //Installation de la librairie mysqlconnect
# sudo apt-get install libboost-dev                                  //Installation de la librairie boost
# sudo apt-get install doxygen graphviz                              //Installation de doxygen pour voir la documentation du code
# dpkg-reconfigure tzdata                                            //Avoir le bon fuseau horaire (choisir 'Europe' -> 'Paris')
# sudo apt-get install libssl-dev 				     //Installation du paquet libssl qui est un protocoles de chiffrement pour sécuriser les communications sur Interne
# sudo apt-get install libmysqlclient-dev                            //Ce paquet comprend les bibliothèques de développement et les fichiers d'entête

Pour copier l'application et le programme sur votre système d'exploitation, vous pouvez utiliser la commande scp.

Pour créer une nouvelle base de données:
#mysql -u root -p
 votre mot de passe de mysql choisi précédemment
#CREATE DATABASE nomdevotrebase;

Importer le fichier sql de la base de données vers mysql :
-> en copiant/collant directement le contenu du fichier de bdd.sql dans la base 'nomdevotrebase' de mysql
-> en effectuant la commande suivante : #mysql -u root -p nomdevotrebase < cheminversle fichiersql

!!! Veillez à changer le nom de la base, de l'utilisateur, de l'hote et votre mot de passe dans les fichiers suivant pour la base de données:
-> Le fichier de conf du programme c++ présent dans /echoclient/conf_bdd.h (#nano conf_bdd.h)
-> Le fichier de conf de l'IHM : 'conf.php' (#nano conf.php)

Pour lancer l'application c++
aller dans le répertoire echoclient où se trouve le fichier echoclient.pro
#qmake
#make
#./echoclient

Lancer l'IHM web
1) Déplacer le répertoire nommé "web" dans le répertoire /var/www de votre système
2) modifier au préalable le fichier de configuration d'apache 000-default.conf du répertoire /etc/apache2/site-available
 #nano 000-default.conf
3) redémarrer apache2 grace à la commande
 #service apache2 restart

Vous pouvez maintenant voir votre site LivingLab en écrivant votre adresse ip à la place de l'url dans votre navigateur préféré

(Pour connaitre son adresse ip : #ifconfig)

Concernant la configuration du laps de temps du graphique, du nombres d'évènement dans l'historique et du choix de la pièce 
-> Changer dans le fichier de conf 'conf.php'


