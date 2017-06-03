#ifndef SMTP_H
#define SMTP_H


#include <QtNetwork/QAbstractSocket>
#include <QtNetwork/QSslSocket>
#include <QString>
#include <QTextStream>
#include <QDebug>
#include <QtWidgets/QMessageBox>
#include <QByteArray>
#include <QSettings>

//Source : https://morf.lv/simple-tls-ssl-smtp-client-for-qt5

/**
 * \class Smtp
 * \brief class qui permet l'envoi de mail par protocole smtp
 */
class Smtp : public QObject
{
    Q_OBJECT

public:
    /**
     * \brief methode principale de la classe smtp pour se conncter au serveur d'envoi smtp
     * \param user : le nom d'utilisateur de la messagerie d'envoie
     * \param pass : le mot de passe de la messagerie d'envoie
     * \param host : l'hote d'envoie
     * \param port : le numéro de port pour l'envoie du mail
     * \param timeout : le temps à ne pas dépasser pour la connection au serveur d'envoie du mail
     */
    Smtp( const QString &user, const QString &pass, const QString &host, int port = 465, int timeout = 30000 );
    ~Smtp();
    /**
     * \brief methode d'envoie du mail
     * \param from : le mail de l'emetteur du mail
     * \param to : le mail du destinataire du mail
     * \param subject : l'intitulé de l'email
     * \param body : le contenu du mail
     */
    void sendMail( const QString &from, const QString &to, const QString &subject, const QString &body );

signals:
    /**
     * \brief emet le statut d'envoie du mail pour dire si il a bien été envoyé ou non
     */
    void status( const QString &);

private slots:
    /**
     * \brief affiche en qDebug le statut de la connexion en socket
     * \param socketState : le statut de la socket
     */
    void stateChanged(QAbstractSocket::SocketState socketState);
    /**
     * \brief affiche en qDebug les erreurs de la socket
     * \param socketError : les erreur de la socket
     */
    void errorReceived(QAbstractSocket::SocketError socketError);
    /**
     * \brief affiche en qDebug que la connection en smtp est deconnectée
     */
    void disconnected();
    /**
     * \brief affiche en qDebug que la connection en smtp est connectée
     */
    void connected();
    /**
     * \brief affiche en qDebug que les différentes erreurs possible par rapport à l'authentification, mot de passe..
     */
    void readyRead();

private:
    int timeout;
    QString message;
    QTextStream *t;
    QSslSocket *socket;
    QString from;
    QString rcpt;
    QString response;
    QString user;
    QString pass;
    QString host;
    int port;
    enum states{Tls, HandShake ,Auth,User,Pass,Rcpt,Mail,Data,Init,Body,Quit,Close};
    int state;

};
#endif
