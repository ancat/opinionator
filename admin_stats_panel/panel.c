#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "libpq-fe.h"

PGresult* perform_query(PGconn*, char*, char**);
void print_last_10_products(PGconn*);
void print_stats(PGconn*);

int main(int argc, char** argv) {
        char* conninfo = "host=localhost dbname=opinionator user=design password=p0stgr3s_is_really_annoying!!";
        PGconn* conn;

        conn = PQconnectdb(conninfo);
        if (PQstatus(conn) != CONNECTION_OK) {
                printf("Failed to connect... %s\n", PQerrorMessage(conn));
                exit(1);
        }

        printf("The last 10 products to be submitted:\n");
        print_last_10_products(conn);
        printf("\n");

        printf("Some Nice Statistics:\n");
        print_stats(conn);
        exit(0);
}

void print_last_10_products(PGconn* connection) {
        char* error_message = "";
        // for some reason, we need to trim these columns :|
        PGresult* res = perform_query(connection, "SELECT product_id, trim(from product_name), trim(from product_image) FROM products ORDER BY product_id DESC LIMIT 10", &error_message);
        if (res) {
                for (int i=0; i < PQntuples(res); i++) {
                        printf("    %s (%s)\n", PQgetvalue(res, i, 1), PQgetvalue(res, i, 2));
                }
        } else {
                printf("Failed to get last 10 products: %s\n", error_message);
        }

        PQclear(res);
}

void print_stats(PGconn* connection) {
        char* error_message = "";
        PGresult* res;

        res = perform_query(connection, "SELECT count(*) FROM products", &error_message);
        if (res) {
                printf("    Total Products: %s\n", PQgetvalue(res, 0, 0));
        } else {
                printf("Failed to retrieve stats: %s\n", error_message);
        }

        PQclear(res);
        res = perform_query(connection, "SELECT count(*) FROM votes", &error_message);
        if (res) {
                printf("    Total Votes: %s\n", PQgetvalue(res, 0, 0));
        } else {
                printf("Failed to retrieve stats: %s\n", error_message);
        }

        PQclear(res);
        res = perform_query(connection, "SELECT count(*) FROM showdowns", &error_message);
        if (res) {
                printf("    Total Showdowns: %s\n", PQgetvalue(res, 0, 0));
        } else {
                printf("Failed to retrieve stats: %s\n", error_message);
        }

        PQclear(res);
}

PGresult* perform_query(PGconn* connection, char* query, char** error_message) {
        PGresult* res = PQexec(connection, query);
        if (PQresultStatus(res) != PGRES_TUPLES_OK) {
                *error_message = PQerrorMessage(connection);
                PQclear(res);
                return NULL;
        }

        *error_message = "No Error";
        return res;
}
