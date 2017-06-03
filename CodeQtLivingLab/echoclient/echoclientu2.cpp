#include "echoclientu2.h"
#include "smtp.h"
#include <QtCore/QDebug>

QT_USE_NAMESPACE

EchoClientU2::EchoClientU2(const QUrl &url, QObject *parent) : QObject(parent), m_url(url)
{
    qDebug() << "WebSocket server:" << url;
    connect(&m_webSocket, &QWebSocket::connected, this, &EchoClientU2::onConnected);//On se connecte au serveur
    connect(&m_webSocket, &QWebSocket::disconnected, this, &EchoClientU2::closed);//On ferme la connexion
    m_webSocket.open(QUrl(url));

}

void EchoClientU2::onConnected()
{
    qDebug() << "WebSocket connected";
    connect(&m_webSocket, &QWebSocket::textMessageReceived,this, &EchoClientU2::onTextMessageReceived);
    m_webSocket.sendTextMessage(QStringLiteral("Hello, world!"));
}


void EchoClientU2::DatabaseConnexion(int var1, QString var2, QString var3)
{
    //on se connect à notre base de donnée
    sql::Driver *driver;
    sql::Connection *con;
    sql::Statement  *stmt;
    sql::PreparedStatement *pstmt;
    driver = get_driver_instance();
    con = driver->connect(HOST, USER, PASS);
    con->setSchema(DB);

    stmt = con->createStatement();
    stmt->execute("use " DB);

    //On insère le nombre de pas
    pstmt = con->prepareStatement("INSERT INTO VALUE (DTIME,ID_SENSOR, NUM, ID_ROOM) VALUES (?, 6, ?, 2)");
    pstmt->setDateTime(1, var2.mid(0,19).toStdString());
    pstmt->setInt(2, var1);
    pstmt->executeUpdate();

    //On insère l'utilisateur dans la base de donnée
    pstmt = con->prepareStatement("INSERT INTO USER_ROOM (MAIL_USER, ID_ROOM) VALUES (?, 2)");
    pstmt->setString(1, var3.toStdString());
    pstmt->executeUpdate();

    verif_mouvement();

    delete pstmt;
    delete stmt;
    delete con;
}

void EchoClientU2::verif_mouvement()
{

    sql::Driver *driver;
    sql::Connection *con;
    sql::Statement  *stmt;
    sql::ResultSet *res;
    sql::PreparedStatement *pstmt;
    driver = get_driver_instance();
    con = driver->connect(HOST, USER, PASS);
    con->setSchema(DB);

    stmt = con->createStatement();
    stmt->execute("use " DB);

    pstmt = con->prepareStatement("SELECT NUM FROM VALUE WHERE ID_SENSOR = 6 AND ID_ROOM= 2");
    res = pstmt->executeQuery();
    res->last();
    //int valeur = res->getInt("NUM");
    //Ne fonctionne pas
    /*
    if(valeur == 0)
    {
        //Par récupération de l'heure
        pstmt = con->prepareStatement("SELECT DTIME FROM VALUE WHERE ID_SENSOR = 6 AND ID_ROOM= 2");
        res = pstmt->executeQuery();
        res->last();
        std::string time = res->getString("DTIME");

        //Si time est compris entre 7h et 23h
        //Créee vraiable ntime auquel on soustait 4h

        pstm = con->prepareStatement("SELECT NUM FROM VALUE WHERE ID_SENSOR = 6 AND ID_ROOM=2 AND DTIME = ?");
        pstmt->setString(1, QString(ntime.c_str()));
        res = pstmt->executeQuery();
        res->last();
        int valeur_quatreh = res->getInt("NUM");

        if(valeur_quatreh == 0)
        {
            pstmt =con->prepareStatement("SELECT MAIL_USER FROM USER_ROOM WHERE ID_ROOM= 2");
            res = pstmt->executeQuery();
            res->last();
            std::string user = res->getString("MAIL_USER");

            qDebug() << "ENVOI sms chute au référent et au samu";
            //Contenant du sms "Attention !! L'utilisateur du LivingLab  de Rennesvient de chuter, il est probable que cette chute ait des répercutions sur la santé de cette personne, merci de faire le nécessaire pour vous assurez qu'il va bien. Cordialement, service technique du LivingLab."
            pstmt = con->prepareStatement("INSERT INTO ALERT (DETAIL, ID_ROOM, MAIL_USER) VALUES ('Alerte SMS declenchee a cause d'une absence de mouvement',2, ?)");
            pstmt->setString(1, QString(user.c_str()).toStdString());
            pstmt->executeUpdate();
        }
    }*/

    delete pstmt;
    delete stmt;
    delete con;
    delete res;
}

void EchoClientU2::onTextMessageReceived(QString message)
{
    qDebug() << "Message received:" << message;
    //{"STEP":71,"TIME":1495543058101,"USER":"Chuck.Norris@isen-ouest.yncrea.fr"}
    QJsonDocument flux_p1 = QJsonDocument::fromJson(message.toUtf8()); //Contient le flux de données sous forme de JsonDocument

    //STEP
    QJsonObject STEP = flux_p1.object();
    QJsonValue pas = STEP.value(QString("STEP")).toDouble();
    double pas_u2 = pas.toDouble();

    //Date et heure
    QJsonObject Date_Heure = flux_p1.object();
    QJsonValue TIMESTAMP = Date_Heure.value(QString("TIME"));
    QDateTime TIMESTAMP_p1;
    TIMESTAMP_p1.setTime_t(TIMESTAMP.toDouble()/1000);

    //Utilisateur
    QJsonObject User = flux_p1.object();
    QString Utilisateur = User.value(QString("USER")).toString();

    DatabaseConnexion(pas_u2, TIMESTAMP_p1.toString(Qt::ISODate), Utilisateur);
}

