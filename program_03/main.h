
#ifndef MAIN_H
#define MAIN_H

//Structure to hold the program's arguments.
struct ProgramArguments {

	std::ifstream infile;
	int64_t epa_bw;
	int64_t epa_cd;
	int64_t clark_bw;
	int64_t clark_cd;
	double wb;
	double wf;
	int64_t cache_size;

};

#endif
