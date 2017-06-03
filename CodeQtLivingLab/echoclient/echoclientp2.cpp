#include "echoclientp2.h"
#include "smtp.h"
#include <QtCore/QDebug>

QT_USE_NAMESPACE

EchoClientP2::EchoClientP2(const QUrl &url, QObject *parent) : QObject(parent), m_url(url)
{
    qDebug() << "WebSocket server:" << url;
    connect(&m_webSocket, &QWebSocket::connected, this, &EchoClientP2::onConnected);//On se connecte au serveur
    connect(&m_webSocket, &QWebSocket::disconnected, this, &EchoClientP2::closed);//On ferme la connexion
    m_webSocket.open(QUrl(url));

}

void EchoClientP2::onConnected()
{
    qDebug() << "WebSocket connected";
    connect(&m_webSocket, &QWebSocket::textMessageReceived,this, &EchoClientP2::onTextMessageReceived);
    m_webSocket.sendTextMessage(QStringLiteral("Hello, world!"));
}

int EchoClientP2::binaryToDecimal(int num)
{
    int decimal_val = 0;
    int base = 0;
    int reste;

    //Conversion de binaire à decimal
    while (num != 0)
    {
       reste = num % 10;
       num /= 10;
       decimal_val += reste*pow(2,base);
       ++base;
    }
    return decimal_val;
}

void EchoClientP2::DatabaseConnexion(int var1, int var2, int var3, int var4, int var5, QString var6, QString var7)
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

    //On insère le CO2 dans la base de donnée
    pstmt = con->prepareStatement("INSERT INTO VALUE (DTIME,ID_SENSOR, NUM, ID_ROOM) VALUES (?, 1, ?,2)");
    pstmt->setDateTime(1, var6.mid(0,19).toStdString());
    pstmt->setInt(2, var1);
    pstmt->executeUpdate();

    //On insère l'humidite dans la base de donnée
    pstmt = con->prepareStatement("INSERT INTO VALUE (DTIME,ID_SENSOR, NUM, ID_ROOM) VALUES (?, 2, ?,2)");
    pstmt->setDateTime(1, var6.mid(0,19).toStdString());
    pstmt->setInt(2, var2);
    pstmt->executeUpdate();

    //On insère la température dans la base de donnée
    pstmt = con->prepareStatement("INSERT INTO VALUE (DTIME,ID_SENSOR, NUM, ID_ROOM) VALUES (?, 3, ?,2)");
    pstmt->setDateTime(1, var6.mid(0,19).toStdString());
    pstmt->setInt(2, var3);
    pstmt->executeUpdate();

    //On insère la chute dans la base de donnée
    pstmt = con->prepareStatement("INSERT INTO VALUE (DTIME,ID_SENSOR, NUM, ID_ROOM) VALUES (?, 4, ?,2)");
    pstmt->setDateTime(1, var6.mid(0,19).toStdString());
    pstmt->setInt(2, var4);
    pstmt->executeUpdate();

    //On insère le four dans la base de donnée
    pstmt = con->prepareStatement("INSERT INTO VALUE (DTIME,ID_SENSOR, NUM, ID_ROOM) VALUES (?, 5, ?,2)");
    pstmt->setDateTime(1, var6.mid(0,19).toStdString());
    pstmt->setInt(2, var5);
    pstmt->executeUpdate();

    //On insère l'utilisateur dans la base de donnée
    pstmt = con->prepareStatement("INSERT INTO USER_ROOM (MAIL_USER, ID_ROOM) VALUES (?, 2)");
    pstmt->setString(1, var7.toStdString());
    pstmt->executeUpdate();

    delete pstmt;
    delete stmt;
    delete con;
}

void EchoClientP2::rec_seuil()
{
    int seuil_haut_CO2;
    int seuil_moy_CO2;
    int seuil_haut_temp;
    int seuil_bas_temp;
    int seuil_haut_hum;
    int seuil_bas_hum;


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

    //Recupération seuil de CO2 haut
    pstmt =con->prepareStatement("SELECT THRESHOLD_HIGH FROM SENSOR WHERE TYPE='CO2'");
    res = pstmt->executeQuery();
    res->first();
    seuil_haut_CO2 = res->getInt("THRESHOLD_HIGH");

    //Recupération seuil de CO2 moyen
    pstmt =con->prepareStatement("SELECT THRESHOLD_LOW FROM SENSOR WHERE TYPE='CO2'");
    res = pstmt->executeQuery();
    res->first();
    seuil_moy_CO2 = res->getInt("THRESHOLD_LOW");

    //Recupération seuil de temperature haut
    pstmt =con->prepareStatement("SELECT THRESHOLD_HIGH FROM SENSOR WHERE TYPE='TEMPERATURE'");
    res = pstmt->executeQuery();
    res->first();
    seuil_haut_temp = res->getInt("THRESHOLD_HIGH");

    //Recupération seuil de temperature bas
    pstmt =con->prepareStatement("SELECT THRESHOLD_LOW FROM SENSOR WHERE TYPE='TEMPERATURE'");
    res = pstmt->executeQuery();
    res->first();
    seuil_bas_temp = res->getInt("THRESHOLD_LOW");

    //Recupération seuil d'humidite haut
    pstmt =con->prepareStatement("SELECT THRESHOLD_HIGH FROM SENSOR WHERE TYPE='HUMIDITE'");
    res = pstmt->executeQuery();
    res->first();
    seuil_haut_hum = res->getInt("THRESHOLD_HIGH");

    //Recupération seuil d'humidite bas
    pstmt =con->prepareStatement("SELECT THRESHOLD_LOW FROM SENSOR WHERE TYPE='HUMIDITE'");
    res = pstmt->executeQuery();
    res->first();
    seuil_bas_hum = res->getInt("THRESHOLD_LOW");

    verif_CO2(seuil_moy_CO2, seuil_haut_CO2);
    verif_temp(seuil_bas_temp, seuil_haut_temp);
    verif_hum(seuil_bas_hum, seuil_haut_hum);
    verif_chute();
    verif_four();

    delete pstmt;
    delete stmt;
    delete con;
    delete res;

}

void EchoClientP2::verif_four()
{
    Smtp *smtp = new Smtp("elevecir2", "Cir2Projet", "smtp.isen-ouest.fr");
    int valeur_moment;

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

    //récupération valeur actuelle du four
    pstmt = con->prepareStatement("SELECT NUM FROM VALUE WHERE ID_SENSOR = 5 AND ID_ROOM= 2");
    res = pstmt->executeQuery();
    res->last();
    valeur_moment = res->getInt("NUM");

    //Si le four est allumé
    if(valeur_moment == 1)
    {
        //Par récupération de l'heure
        //Ne fonctionne pas
        /*pstmt = con->prepareStatement("SELECT DTIME FROM VALUE WHERE ID_SENSOR = 5 AND ID_ROOM= 2");
        res = pstmt->executeQuery();
        res->last();
        std::string time = res->getString("DTIME");
        QDateTime date;
        QString ntime = date.fromString(QString(time.c_str()).addSecs(-7200).toString();


        //Nous n'avons pas réussi à soustraire 2h à QString(time.c_str()) dans une nouvelle variable ntime

        pstm = con->prepareStatement("SELECT NUM FROM VALUE WHERE ID_SENSOR = 5 AND ID_ROOM=2 AND DTIME = ?");
        pstmt->setString(1, ntime.toStdString());
        res = pstmt->executeQuery();
        res->last();
        int valeur_deuxh = res->getInt("NUM");

        if(valeur_deuxh == 1)
        {
            //Récupération mail_contact

            pstmt =con->prepareStatement("SELECT MAIL_USER FROM USER_ROOM WHERE ID_ROOM= 2");
            res = pstmt->executeQuery();
            res->last();
            std::string user = res->getString("MAIL_USER");

            pstmt = con->prepareStatement("SELECT MAIL_CONTACT FROM USER_CONTACT WHERE MAIL_USER = ?");
            pstmt->setString(1, QString(user.c_str()).toStdString());
            res = pstmt->executeQuery();
            res->last();
            std::string mail = res->getString("MAIL_CONTACT");


            smtp->sendMail("quentin.bourdonnec@isen-bretagne.fr", QString(mail.c_str()) , "Alerte du four au LivingLab de Brest", "Attention !! L'alerte du four vient de se declencher au LivingLab, cela fait plus de 2 heures qu'il est allume, les risques sont le depart d'un incendie si il n'est pas eteint assez rapidement, merci de passer l'eteindre dans les plus bref delais. Cordialement, le service technique du LivingLab.!");
            pstmt = con->prepareStatement("INSERT INTO ALERT (DETAIL, ID_ROOM, MAIL_USER) VALUES ('Alerte declenchee a cause du four au LivingLab de Brest', 2, ?)");
            pstmt->setString(1, QString(user.c_str()).toStdString());
            pstmt->executeUpdate();
        }*/

        pstmt =con->prepareStatement("SELECT MAIL_USER FROM USER_ROOM WHERE ID_ROOM= 2");
        res = pstmt->executeQuery();
        res->last();
        std::string user = res->getString("MAIL_USER");

        pstmt = con->prepareStatement("SELECT MAIL_CONTACT FROM USER_CONTACT WHERE MAIL_USER = ?");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        res = pstmt->executeQuery();
        res->last();
        std::string mail = res->getString("MAIL_CONTACT");


        smtp->sendMail("quentin.bourdonnec@isen-bretagne.fr", QString(mail.c_str()) , "Alerte du four au LivingLab de Brest", "Attention !! L'alerte du four vient de se declencher au LivingLab, cela fait plus de 2 heures qu'il est allume, les risques sont le depart d'un incendie si il n'est pas eteint assez rapidement, merci de passer l'eteindre dans les plus bref delais. Cordialement, le service technique du LivingLab.!");
        pstmt = con->prepareStatement("INSERT INTO ALERT (DETAIL, ID_ROOM, MAIL_USER) VALUES ('Alerte declenchee a cause du four au LivingLab de Brest', 2, ?)");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        pstmt->executeUpdate();

    }

    delete pstmt;
    delete stmt;
    delete con;
    delete res;



}

void EchoClientP2::verif_chute()
{
    int valeur;
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

    pstmt = con->prepareStatement("SELECT NUM FROM VALUE WHERE ID_SENSOR = 4 AND ID_ROOM= 2");
    res = pstmt->executeQuery();
    res->last();
    valeur = res->getInt("NUM");

    if(valeur == 1)
    {
        pstmt =con->prepareStatement("SELECT MAIL_USER FROM USER_ROOM WHERE ID_ROOM= 2");
        res = pstmt->executeQuery();
        res->last();
        std::string user = res->getString("MAIL_USER");

        qDebug() << "ENVOI sms chute au référent et au samu";
        //Contenant du sms "Attention !! L'utilisateur du LivingLab  de Rennesvient de chuter, il est probable que cette chute ait des répercutions sur la santé de cette personne, merci de faire le nécessaire pour vous assurez qu'il va bien. Cordialement, service technique du LivingLab."
        pstmt = con->prepareStatement("INSERT INTO ALERT (DETAIL, ID_ROOM, MAIL_USER) VALUES ('Alerte SMS declenchee a cause de chute',2, ?)");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        pstmt->executeUpdate();
    }

    delete pstmt;
    delete stmt;
    delete con;
    delete res;
}

void EchoClientP2::verif_hum(int a, int b)
{
    Smtp *smtp = new Smtp("elevecir2", "Cir2Projet", "smtp.isen-ouest.fr");
    int valeur;
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

    pstmt = con->prepareStatement("SELECT NUM FROM VALUE WHERE ID_SENSOR = 3 AND ID_ROOM= 2");
    res = pstmt->executeQuery();
    res->last();
    valeur = res->getInt("NUM");

    if(valeur < a || valeur > b)
    {

        pstmt =con->prepareStatement("SELECT MAIL_USER FROM USER_ROOM WHERE ID_ROOM= 2");
        res = pstmt->executeQuery();
        res->last();
        std::string user = res->getString("MAIL_USER");

        pstmt = con->prepareStatement("SELECT MAIL_CONTACT FROM USER_CONTACT WHERE MAIL_USER = ?");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        res = pstmt->executeQuery();
        res->last();
        std::string mail = res->getString("MAIL_CONTACT");

        //QString(mail.c_str())
        smtp->sendMail("quentin.bourdonnec@isen-bretagne.fr", QString(mail.c_str()) , "Alerte d'humidite au LivingLab de Rennes", "Attention !! Le taux d'humidite est anormalement eleve au sein du LivingLab, cette humidite peut être signe d'inondation et peut causer de nombreux dommages. Merci de faire le nécessaire et vous assurer que l'utilisateur est en bonne sante car ce taux d'humite important peut causer des troubles respiratoires. Cordialement, service technique du LivingLab.");
        pstmt = con->prepareStatement("INSERT INTO ALERT (DETAIL, ID_ROOM, MAIL_USER) VALUES ('Alerte mail declenchee à cause de humidite en dehors des seuils',2, ?)");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        pstmt->executeUpdate();
    }

    delete pstmt;
    delete stmt;
    delete con;
    delete res;

}

void EchoClientP2::verif_temp(int a, int b)
{
    Smtp *smtp = new Smtp("elevecir2", "Cir2Projet", "smtp.isen-ouest.fr");
    int valeur_mom;
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

    //Envoi mail si la température dépasse les seuils
    pstmt = con->prepareStatement("SELECT NUM FROM VALUE WHERE ID_SENSOR = 2 AND ID_ROOM= 2");
    res = pstmt->executeQuery();
    res->last();
    valeur_mom = res->getInt("NUM");

    if(valeur_mom < a || valeur_mom > b)
    {

        pstmt =con->prepareStatement("SELECT MAIL_USER FROM USER_ROOM WHERE ID_ROOM= 2");
        res = pstmt->executeQuery();
        res->last();
        std::string user = res->getString("MAIL_USER");

        pstmt = con->prepareStatement("SELECT MAIL_CONTACT FROM USER_CONTACT WHERE MAIL_USER = ?");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        res = pstmt->executeQuery();
        res->last();
        std::string mail = res->getString("MAIL_CONTACT");

        //QString(mail.c_str())
        smtp->sendMail("quentin.bourdonnec@isen-bretagne.fr", QString(mail.c_str()) , "Alerte de temperature (seuils) au LivingLab de Rennes", "Attention !! La temperature est anormalement eleve au sein du LivingLab. Cette  temperature peut etre signe de depart d'incendie et peut causer de nombreux dommages. Merci de faire le necessaire et vous assurer que l'utilisateur est en bonne sante car cette forte temperature peut causer des troubles respiratoires ainsi que d'autres problemes. Verifiez que l'ensemble des appareils electromenagers sont bien eteint. Cordialement, service technique du LivingLab.");
        pstmt = con->prepareStatement("INSERT INTO ALERT (DETAIL, ID_ROOM, MAIL_USER) VALUES ('Alerte mail declenchee à cause de temperature en dehors des seuils',2, ?)");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        pstmt->executeUpdate();
    }


    //Envoi mail augmentation de plus de 3 degrés en 5 minutes
    //Ne fonctionne pas
    //Par récupération de l'heure
    /*pstmt = con->prepareStatement("SELECT DTIME FROM VALUE WHERE ID_SENSOR = 2 AND ID_ROOM= 2");
    res = pstmt->executeQuery();
    res->last();
    std::string time = res->getString("DTIME");
    QDateTime date;
    QString ntime = date.fromString(QString(time.c_str()).addSecs(-300).toString();


    //Nous n'avons pas réussi à soustraire 5minutes à QString(time.c_str()) dans une nouvelle variable ntime

    pstm = con->prepareStatement("SELECT NUM FROM VALUE WHERE ID_SENSOR = 2 AND ID_ROOM=2 AND DTIME = ?");
    pstmt->setString(1, ntime.toStdString());
    res = pstmt->executeQuery();
    res->last();
    int valeur_cinqm = res->getInt("NUM");

    int diff = valeur_mom - valeur_cinqm;
    //Gérer si la température descend pas grave, mais si sa monte, risque incendie
    if(fabs(diff) > 3)
    {
        //qDebug() << "ENVOI mail temp";

        pstmt =con->prepareStatement("SELECT MAIL_USER FROM USER_ROOM WHERE ID_ROOM= 2");
        res = pstmt->executeQuery();
        res->last();
        std::string user = res->getString("MAIL_USER");

        pstmt = con->prepareStatement("SELECT MAIL_CONTACT FROM USER_CONTACT WHERE MAIL_USER = ?");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        res = pstmt->executeQuery();
        res->last();
        std::string mail = res->getString("MAIL_CONTACT");

        //QString(mail.c_str())
        smtp->sendMail("quentin.bourdonnec@isen-bretagne.fr", QString(mail.c_str()) , "Alerte de temperature (augmentation) au LivingLab de Rennes" ,"Attention !! La temperature vient d'augmenter de 3°C au cours de ces 5 dernieres minutes, et est anormalement eleve au sein du LivingLab. Cette  temperature peut etre signe de depart d'incendie et peut causer de nombreux dommages. Merci de faire le necessaire et vous assurer que l'utilisateur est en bonne sante car cette forte temperature peut causer des troubles respiratoires ainsi que d'autres problemes. Verifiez que l'ensemble des appareils electromenagers sont bien eteint. Cordialement, service technique du LivingLab.");
        pstmt = con->prepareStatement("INSERT INTO ALERT (DETAIL, ID_ROOM, MAIL_USER) VALUES ('Alerte mail declenchee a cause de hausse de temperature de 3deg en moins de 5 minutes',2, ?)");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        pstmt->executeUpdate();
    }*/


    delete pstmt;
    delete stmt;
    delete con;
    delete res;

}

void EchoClientP2::verif_CO2(int a, int b)
{
    Smtp *smtp = new Smtp("elevecir2", "Cir2Projet", "smtp.isen-ouest.fr");
    int valeur;
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

    pstmt = con->prepareStatement("SELECT NUM FROM VALUE WHERE ID_SENSOR =1 AND ID_ROOM= 2");
    res = pstmt->executeQuery();

    res->last();
    valeur = res->getInt("NUM");

    if(valeur > a)
    {
        pstmt =con->prepareStatement("SELECT MAIL_USER FROM USER_ROOM WHERE ID_ROOM= 2");
        res = pstmt->executeQuery();
        res->last();
        std::string user = res->getString("MAIL_USER");

        pstmt = con->prepareStatement("SELECT MAIL_CONTACT FROM USER_CONTACT WHERE MAIL_USER = ?");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        res = pstmt->executeQuery();
        res->last();
        std::string mail = res->getString("MAIL_CONTACT");

        //QString(mail.c_str())
        smtp->sendMail("quentin.bourdonnec@isen-bretagne.fr", QString(mail.c_str()) , "Alerte de CO2 au LivingLab de Rennes","Attention !! Le taux de CO2 est anormalement eleve au sein du LivingLab, ce taux peut etre signe de depart d'incendie et peut causer de nombreux dommages. Merci de faire le necessaire et vous assurer que l'utilisateur est en bonne sante car ce taux de CO2 important peut causer des troubles respiratoires. Cordialement, service technique du LivingLab.");
        pstmt = con->prepareStatement("INSERT INTO ALERT (DETAIL, ID_ROOM, MAIL_USER) VALUES ('Alerte mail declenchee à cause de CO2 au dessus du seuil maximum',2, ?)");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        pstmt->executeUpdate();
    }
    if(valeur > b)
    {
        pstmt =con->prepareStatement("SELECT MAIL_USER FROM USER_ROOM WHERE ID_ROOM= 2");
        res = pstmt->executeQuery();
        res->last();
        std::string user = res->getString("MAIL_USER");
        qDebug() << "ENVOI SMS co2";
        pstmt = con->prepareStatement("INSERT INTO ALERT (DETAIL, ID_ROOM, MAIL_USER) VALUES ('Alerte SMS déclenchee à cause de CO2 au dessus du seuil maximum',2, ?)");
        pstmt->setString(1, QString(user.c_str()).toStdString());
        pstmt->executeUpdate();
    }

    delete pstmt;
    delete stmt;
    delete con;
    delete res;

}

void EchoClientP2::onTextMessageReceived(QString message)
{



    qDebug() << "Message received:" << message;
    //{"CO2":480,"FALL":0,"MTH02":"000000101010110101001010111111111111111111111111","OVEN":false,"TIME":1494842451680,"TV":"off","USER":"Chuck Norris"}
    QJsonDocument flux_p1 = QJsonDocument::fromJson(message.toUtf8()); //Contient le flux de données sous forme de JsonDocument

    //CO2
    QJsonObject CO2 = flux_p1.object();
    QJsonValue taux_CO2 = CO2.value(QString("CO2")).toDouble();
    double taux_CO2_p1 = taux_CO2.toDouble();

    //Chute
    QJsonObject tombe = flux_p1.object();
    QJsonValue Chute = tombe["FALL"].toBool();
    bool Chute_p1 = Chute.toBool();

    //Four
    QJsonObject Oven = flux_p1.object();
    QJsonValue Four = Oven.value(QString("OVEN")).toBool();
    bool Four_p1 = Four.toBool();

    //Date et heure
    QJsonObject Date_Heure = flux_p1.object();
    QJsonValue TIMESTAMP = Date_Heure.value(QString("TIME"));
    QDateTime TIMESTAMP_p1;
    TIMESTAMP_p1.setTime_t(TIMESTAMP.toDouble()/1000);

    //Utilisateur
    QJsonObject User = flux_p1.object();
    QString Utilisateur = User.value(QString("USER")).toString();

    //MTH02
    QJsonObject temp_hum = flux_p1.object();
    QJsonValue MTH02 = temp_hum.value(QString("MTH02"));
    QString temperature = MTH02.toString().mid(0,16);
    QString humidite = MTH02.toString().mid(16,8);
    int temperature_p1 = (binaryToDecimal(temperature.toInt())-400)*pow(10,-1);
    int humidite_p1 = binaryToDecimal(humidite.toInt());

    DatabaseConnexion(taux_CO2_p1, temperature_p1, humidite_p1, Chute_p1, Four_p1, TIMESTAMP_p1.toString(Qt::ISODate), Utilisateur);
    rec_seuil();

}


