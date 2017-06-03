README du LivingLab

Veuillez effectuer ces installations au pr�alable (librairies et applications) sur votre syst�me d'exploitation linux 16.04 
gr�ce aux commandes suivantes :

# sudo apt-get update                                                //Pour mettre � jour la liste des fichiers disponibles dans les d�p�ts APT
# sudo apt-get install mysql-server                                  //Installation de mysql (choisir un mot de passe de votre choix)
# sudo apt-get install phpmyadmin                                    //Installation de phpmyadmin ('espace' sur apache2, 'ctrl' puis 'entree')
# sudo apt-get install libmysqlcppconn-dev                           //Installation de la librairie mysqlconnect
# sudo apt-get install libboost-dev                                  //Installation de la librairie boost
# sudo apt-get install doxygen graphviz                              //Installation de doxygen pour voir la documentation du code
# dpkg-reconfigure tzdata                                            //Avoir le bon fuseau horaire (choisir 'Europe' -> 'Paris')
# sudo apt-get install libssl-dev 				     //Installation du paquet libssl qui est un protocoles de chiffrement pour s�curiser les communications sur Interne
# sudo apt-get install libmysqlclient-dev                            //Ce paquet comprend les biblioth�ques de d�veloppement et les fichiers d'ent�te

Pour copier l'application et le programme sur votre syst�me d'exploitation, vous pouvez utiliser la commande scp.

Pour cr�er une nouvelle base de donn�es:
#mysql -u root -p
 votre mot de passe de mysql choisi pr�c�demment
#CREATE DATABASE nomdevotrebase;

Importer le fichier sql de la base de donn�es vers mysql :
-> en copiant/collant directement le contenu du fichier de bdd.sql dans la base 'nomdevotrebase' de mysql
-> en effectuant la commande suivante : #mysql -u root -p nomdevotrebase < cheminversle fichiersql

!!! Veillez � changer le nom de la base, de l'utilisateur, de l'hote et votre mot de passe dans les fichiers suivant pour la base de donn�es:
-> Le fichier de conf du programme c++ pr�sent dans /echoclient/conf_bdd.h (#nano conf_bdd.h)
-> Le fichier de conf de l'IHM : 'conf.php' (#nano conf.php)

Pour lancer l'application c++
aller dans le r�pertoire echoclient o� se trouve le fichier echoclient.pro
#qmake
#make
#./echoclient

Lancer l'IHM web
1) D�placer le r�pertoire nomm� "web" dans le r�pertoire /var/www de votre syst�me
2) modifier au pr�alable le fichier de configuration d'apache 000-default.conf du r�pertoire /etc/apache2/site-available
 #nano 000-default.conf
3) red�marrer apache2 grace � la commande
 #service apache2 restart

Vous pouvez maintenant voir votre site LivingLab en �crivant votre adresse ip � la place de l'url dans votre navigateur pr�f�r�

(Pour connaitre son adresse ip : #ifconfig)

Concernant la configuration du laps de temps du graphique, du nombres d'�v�nement dans l'historique et du choix de la pi�ce 
-> Changer dans le fichier de conf 'conf.php'


