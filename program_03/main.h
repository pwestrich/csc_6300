
#ifndef MAIN_H
#define MAIN_H

#include <cstdint>
#include <fstream>

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

struct SimulationResults {

	int64_t cacheHits;
	int64_t cacheMisses;
	int64_t replacementPolicyCalls;
	int64_t maxObjectsReplaced;
	int64_t lowestUV;
	int64_t highestUV;

};

#endif
