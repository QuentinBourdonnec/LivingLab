#ifndef ECHOCLIENTU2_H
#define ECHOCLIENTU2_H


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
 * \file echoclientu2.h
 * \brief Gestion du deuxième utilisateur
 * \author Bourdonnec Quentin et Clouet Matthias
 * \date 31 Mai 2017
 */



/**
 * \class EchoClient
 * \brief class qui gere les donnees de l'utilisateur de la premiere piece d'ip 192.168.199.31, ip récupérée précedemment dans le main
 */
class EchoClientU2 : public QObject
{
    Q_OBJECT
public:
    /**
     * \brief methode principale de la classe EchoClient permettant de se connecter au serveur
     * \param url : prend l'adresse ip et le port de l'a piece 1'utilisateur 2
     */
    explicit EchoClientU2(const QUrl &url,  QObject *parent = Q_NULLPTR);

Q_SIGNALS:
    void closed();

private Q_SLOTS:
    /**
     * \brief apres la connexion précédente, nous ouvrons le socket à l'url donnée donc à l'adresse ip et au port de la première piece
     */
    void onConnected();
    /**
     * \brief methode pour recevoir les messages de l'url
     * \param message : contenant le message reçu de l'url
     */
    void onTextMessageReceived(QString message);
    /**
     * \brief connection à la base mysql grace à mysqlconnector
     * \param var1 : le nombre de pas de l'utilisateur 2
     * \param var2 : la date au format TIMESTAMP
     * \param var3 : l'identifiant de l'utilisateur qui est ici une adresse mail
     */
    void DatabaseConnexion(int var1, QString var2, QString var3);
    /**
     * \brief méthode de vérification de mouvement, prenant en compte le nombre de pas réalisé dans une journée
     */
    void verif_mouvement();

private:
    QWebSocket m_webSocket;
    QUrl m_url;


};

#endif // ECHOCLIENTU2_H
