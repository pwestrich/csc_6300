
#ifndef OBJECT_H
#define OBJECT_H

#include <cstdint>
#include <string>

enum Server {

	ServerNone = 0,
	ServerClark,
	ServerEPA

};

struct FetchedObject {

	std::string resource;
	int64_t size;
	Server server;

};

std::string server2string(const Server server);
Server string2server(const std::string &server);
FetchedObject readFromFile(std::ifstream &in);

#endif
