#include <QtCore/QCoreApplication>
#include <QtCore/QCommandLineParser>
#include <QtCore/QCommandLineOption>
#include "echoclient.h"
#include "smtp.h"
#include "echoclientp2.h"
#include "echoclientu1.h"
#include "echoclientu2.h"



int main(int argc, char *argv[])
{
    QCoreApplication a(argc, argv);

    sql::Driver *driver;
    sql::Connection *con;
    sql::Statement  *stmt;
    sql::PreparedStatement *pstmt;
    sql::ResultSet *res;
    driver = get_driver_instance();
    con = driver->connect(HOST, USER, PASS);
    con->setSchema(DB);
    stmt = con->createStatement();
    stmt->execute("use " DB);


    pstmt =con->prepareStatement("SELECT IP FROM ROOM WHERE ID_ROOM = 1");
    res = pstmt->executeQuery();
    res->first();
    std::string IP1 = res->getString("IP");

    pstmt =con->prepareStatement("SELECT IP FROM ROOM WHERE ID_ROOM = 2");
    res = pstmt->executeQuery();
    res->first();
    std::string IP2 = res->getString("IP");

    pstmt =con->prepareStatement("SELECT PORT_R FROM ROOM WHERE ID_ROOM = 1");
    res = pstmt->executeQuery();
    res->first();
    std::string PORT_R1 = res->getString("PORT_R");

    pstmt =con->prepareStatement("SELECT PORT_R FROM ROOM WHERE ID_ROOM = 2");
    res = pstmt->executeQuery();
    res->first();
    std::string PORT_R2 = res->getString("PORT_R");

    pstmt =con->prepareStatement("SELECT PORT_U FROM ROOM WHERE ID_ROOM = 1");
    res = pstmt->executeQuery();
    res->first();
    std::string PORT_U1 = res->getString("PORT_U");

    pstmt =con->prepareStatement("SELECT PORT_U FROM ROOM WHERE ID_ROOM = 2");
    res = pstmt->executeQuery();
    res->first();
    std::string PORT_U2 = res->getString("PORT_U");



    EchoClient client(QUrl("ws://"+QString(IP1.c_str())+":"+QString(PORT_R1.c_str())));
    QObject::connect(&client, &EchoClient::closed, &a, &QCoreApplication::quit);

    EchoClientP2 clientP2(QUrl("ws://"+QString(IP2.c_str())+":"+QString(PORT_R2.c_str())));
    QObject::connect(&clientP2, &EchoClientP2::closed, &a, &QCoreApplication::quit);

    Smtp *smtp = new Smtp("elevecir2", "Cir2Projet", "smtp.isen-ouest.fr");
    QObject::connect(smtp, SIGNAL(status(QString)), &a, SLOT(mailSent(QString)));

    EchoClientU1 clientu1(QUrl("ws://"+QString(IP1.c_str())+":"+QString(PORT_U1.c_str())));
    QObject::connect(&clientu1, &EchoClientU1::closed, &a, &QCoreApplication::quit);

    EchoClientU2 clientu2(QUrl("ws://"+QString(IP2.c_str())+":"+QString(PORT_U2.c_str())));
    QObject::connect(&clientu2, &EchoClientU2::closed, &a, &QCoreApplication::quit);

    return a.exec();
}



