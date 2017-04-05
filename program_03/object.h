
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

std::string server2string(const Server server){

	switch(server){

		case ServerClark: return "Clark",
		case ServerEPA	: return "EPA",
		default			: return "none"

	}

}

//Reads a single line from the specified istream and makes an object from it
FetchedObject readFromFile(std::istream &in){

	return {server2string(ServerNone), 0, ServerNone};

}

#endif
