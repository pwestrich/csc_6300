
#ifndef HYBRID_CACHE_H
#define HYBRID_CACHE_H

#include <map>
#include <vector>

#include "object.h"

struct ProgramArguments;
struct SimulationResults;

class HybridCache {

private:

	struct CachedObject {

		FetchedObject object;
		int64_t hits;
		int64_t uv;

		bool operator>(const CachedObject &other){

			return this->uv > other.uv;

		};

	};

	const ProgramArguments &args;

	std::map<std::string, size_t> cacheMap;						//Maps the resource strings to their indexes in the cache array
	std::vector<std::pair<size_t, CachedObject&>> sortedCache;	//Cache in sorted order
	std::vector<CachedObject> cache;							//The array of objects in the cache
	int64_t currentCacheSize;									//How big is the cache?

	//Calculates the UV for a given object
	int64_t calculateUV(const FetchedObject &object) const;

public:

	HybridCache(const ProgramArguments &_args) : args(_args), currentCacheSize(0){};

	//Gets an object from the cache.
	//Returns true if it was found, false elsewise
	bool getObject(FetchedObject object);

	//Attempts to add on object to the cache
	//Returns true if it was, false otherwise
	bool addToCache(FetchedObject object);

};

//Runs the simulation with the given arguments.
SimulationResults simulateHybridCache(const ProgramArguments &args);

#endif
