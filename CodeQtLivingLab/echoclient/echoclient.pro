QT       += core websockets
QT       -= gui
QT += sql

TARGET = echoclient
CONFIG   += console
CONFIG   -= app_bundle

QTPLUGIN += QSQLMYSQL
TEMPLATE = app

SOURCES += \
    main.cpp \
    echoclient.cpp \
    smtp.cpp \
    echoclientp2.cpp \
    echoclientu1.cpp \
    echoclientu2.cpp

HEADERS += \
    echoclient.h \
    smtp.h \
    echoclientp2.h \
    echoclientu1.h \
    echoclientu2.h \
    conf_bdd.h

target.path = $$[QT_INSTALL_EXAMPLES]/websockets/echoclient
INSTALLS += target

INCLUDEPATH += ../mysql-connector-c++-1.1.9-linux-ubuntu16.04-x86-64bit/include
LIBS += ../mysql-connector-c++-1.1.9-linux-ubuntu16.04-x86-64bit/lib/libmysqlcppconn.so

