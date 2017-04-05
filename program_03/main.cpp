
#include <cstdint>
#include <fstream>
#include <iostream>

#include "main.h"

//Prints the program's usage to the specified ostream.
void usage(std::ostream &out, const char *name){

	out << "Usage: " << name << " $infile $epa_bw $epa_cd $clark_bw $clark_cd $wb $wf $cache_size" 	<< std::endl;
	out << "   where $epa_bw, $epa_cd, $clark_bw, $clark_cd, $cache_size are positive integers," 	<< std::endl;
	out << "   and $infile is the name of the file to read from," 									<< std::endl;
	out << "   and $wb, $wf are floating point numbers." 											<< std::endl;

}

int main(const int argc, const char *argv[]){

	//check argument count
	if (argc < 9){

		std::cerr << "Error: Too few arguments." << std::endl;
		usage(std::cerr, argv[0]);
		exit(EXIT_FAILURE);

	}

	//parse arguments
	const ProgramArguments args = {

		std::ifstream(argv[1]),
		atoll(argv[2]),
		atoll(argv[3]),
		atoll(argv[4]),
		atoll(argv[5]),
		std::stod(argv[6]),
		std::stod(argv[7]),
		atoll(argv[8]) * 1048576 // convert megabytes to bytes so sizes match

	};

	if (!args.infile){

		std::cerr << "Error: Can't open " << argv[1] << " for reading." << std:: endl;
		usage(std::cerr, argv[0]);
		return EXIT_FAILURE;

	} else if (args.epa_bw <= 0){

		std::cerr << "Error: Negative bandwidth won't get you anywhere: epa_bw " << args.epa_bw << " is less than 1." << std::endl;
		usage(std::cerr, argv[0]);
		return EXIT_FAILURE;

	} else if (args.epa_cd <= 0){

		std::cerr << "Error: The data can't get here before I ask for it: epa_cd " << args.epa_cd << " is less than 1." << std::endl;
		usage(std::cerr, argv[0]);
		return EXIT_FAILURE;

	} else if (args.clark_cd <= 0){

		std::cerr << "Error: Negative bandwidth won't get you anywhere: clark_bw " << args.clark_bw << " is less than 1." << std::endl;
		usage(std::cerr, argv[0]);
		return EXIT_FAILURE;

	} else if (args.clark_bw <= 0){

		std::cerr << "Error: The data can't get here before I ask for it: clark_cd " << args.clark_bw << " is less than 1." << std::endl;
		usage(std::cerr, argv[0]);
		return EXIT_FAILURE;

	} else if (args.cache_size <= 0){

		std::cerr << "Error: What's the point? Cache size  " << args.cache_size << " is less than 1." << std::endl;
		usage(std::cerr, argv[0]);
		return EXIT_FAILURE;

	}

	//Arguments parsed, now proceed to do the work
	std::cout << "Simulating hybrid cache..." << std::endl;


	return 0;

}
