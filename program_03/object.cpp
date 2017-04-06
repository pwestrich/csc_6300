
#include <fstream>
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
std::istream& operator >>(std::istream &in, FetchedObject &object){

	std::string server, date, time;

	in >> server >> date >> time >> object.resource >> object.size;
	object.server = string2server(server);

	return in;

}

//writes a single line to a file
std::ostream& operator <<(std::ostream &out, const FetchedObject &object){

	return out << server2string(object.server) << " " << object.resource << " " << object.size << std::endl;

}
