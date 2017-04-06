
#include <string>

#include "object.h"

std::string server2string(const Server server){

	switch (server){

		case ServerClark : return "clark";
		case ServerEPA	  : return "epa";
		default			  : return "none";

	}

}

Server string2server(const std::string &server){

	if (server == "clark"){

		return ServerClark;

	} else if (server == "epa"){

		return ServerEPA;

	} else return ServerNone;

}

//Reads a single line from the specified istream and makes an object from it
FetchedObject readFromFile(std::ifstream &in){

	std::string server, date, time, resource, size;

	std::getline(in, server, ' ');
   std::getline(in, date, ' ');
   std::getline(in, time, ' ');
   std::getline(in, resource, ' ');
   std::getline(in, size, '\n');

	return {resource, stoll(size), string2server(server)};

}
