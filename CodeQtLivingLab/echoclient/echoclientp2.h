#ifndef ECHOCLIENTP2_H
#define ECHOCLIENTP2_H

#include <QtCore/QObject>
#include <QtWebSockets/QWebSocket>
#include <QJsonDocument>
#include <QJsonObject>
#include <QJsonValue>
#include <QJsonArray>
#include <QJsonParseError>
#include <QString>
#include <QtSql>
#include <QSqlError>
#include <QDateTime>
#include <QTextCodec>
#include <QSettings>
#include "conf_bdd.h"

#include "mysql_connection.h"

#include <cppconn/driver.h>
#include <cppconn/exception.h>
#include <cppconn/resultset.h>
#include <cppconn/statement.h>
#include <cppconn/prepared_statement.h>

/**
 * \file echoclientp2.h
 * \brief Gestion de la deuxième piece
 * \author Bourdonnec Quentin et Clouet Matthias
 * \date 31 Mai 2017
 */



/**
 * \class EchoClient
 * \brief class qui gere les donnees de la deuxième piece d'ip 192.168.199.31, ip récupérée précedemment dans le main
 */
class EchoClientP2 : public QObject
{
    Q_OBJECT
public:
    /**
     * \brief methode principale de la classe EchoClient permettant de se connecter au serveur
     * \param url : prend l'adresse ip et le port de la piece 2
     */
    explicit EchoClientP2(const QUrl &url,  QObject *parent = Q_NULLPTR);

Q_SIGNALS:
    void closed();

private Q_SLOTS:
    /**
     * \brief apres la connexion précédente, nous ouvrons le socket à l'url donnée donc à l'adresse ip et au port de la deuxième piece
     */
    void onConnected();
    /**
     * \brief methode pour recevoir les messages de l'url
     * \param message : contenant le message reçu de l'url
     */
    void onTextMessageReceived(QString message);
    /**
     * \brief methode de conversion de binaire à décimal du MTH02 pour obtenir l'humidité et la température
     * \return nous retournons la valeur du MTH02 convertit en décimal
     */
    int binaryToDecimal(int num);
    /**
     * \brief connection à la base mysql grace à mysqlconnector
     * \param var1 : le taux de CO2 de la deuxième pièce
     * \param var2 : la température de la deuxième pièce
     * \param var3 : l'humidité de la deuxième pièce
     * \param var4 : la chute de la deuxième pièce (valeur booléenne, 0 si rien, 1 si présence de chute)
     * \param var5 : le four de la deuxième pièce (valeure booléenne, 0 si le four est éteint, 1 si il est allumé)
     * \param var6 : la date et l'heure en TIMESTAMP
     * \param var7 : L'utilisateur de la deuxième pièce, ici son adresse email
     */
    void DatabaseConnexion(int var1, int var2, int var3, int var4, int var5, QString var6, QString var7);
    /**
     * \brief méthode de comparaison du taux de CO2 par rapport aux 2 seuils, envois d'alerte mails ou sms si cela dépasse les seuils
     * \param a : le seuil moyen de CO2, ici 1000 ppm
     * \param b : le seuil haut de CO2, ici 1500 ppm
     */
    void verif_CO2(int a, int b);
    /**
     * \brief méthode de comparaison de la donnée température par rapport aux seuils minimal et maximal, envois d'un mail si cette donnée n'est pas comprise entre ces deux seuils
     * \param a : le seuil bas de la température, ici 17°C
     * \param b : le seuil haut de la température, ici 29°C
     */
    void verif_temp(int a, int b);
    /**
     * \brief méthode de comparaison de la donnée humidité de la piece 1 par rapport aux seuils minimal et maximal, envois d'un email au référent si cette valeur n'est pas comprise dans les seuils
     * \param a : le seuil d'humidité minimal, ici 35%
     * \param b : le seuil d'humidité maximal, ici 70%
     */
    void verif_hum(int a, int b);
    /**
     * \brief méthode de vérification si l'utilisateur à chuté ou non, valeur booléenne de la chute donc si la valeur est 1, envoi d'un sms
     */
    void verif_chute();
    /**
     * \brief méthode de vérification de l'état du four, si la valeur est 1 alors envois d'un sms au référent car il y a un risque d'incendie
     */
    void verif_four();
    /**
     * \brief méthode de récupération des différents seuils dans la base de données,
     */
    void rec_seuil();

private:
    QWebSocket m_webSocket;
    QUrl m_url;


};

#endif // ECHOCLIENTP2_H
