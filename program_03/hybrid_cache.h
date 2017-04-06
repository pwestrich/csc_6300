
#ifndef HYBRID_CACHE_H
#define HYBRID_CACHE_H

#include <limits>
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
		double uv;

		bool operator>(const CachedObject &other){

			return this->uv > other.uv;

		};

	};

	const ProgramArguments &args;

	std::map<std::string, size_t> cacheMap;	//Maps the resource strings to their indexes in the cache array
	std::vector<size_t> sortedCache;				//Cache in sorted order
	std::vector<CachedObject> cache;				//The array of objects in the cache
	
	int64_t currentCacheSize = 0;					//How big is the cache?
	int64_t replacemetPolicyCalls = 0;
	int64_t largestObjectsReplaced = 0;
	double lowestUV = std::numeric_limits<double>::max();
	double highestUV= std::numeric_limits<double>::min();

	//Calculates the UV for a given object
	void calculateUV(CachedObject &object);

	//replaces some objects with the given one
	void replaceObjects(const CachedObject &object);

	void _addToCache(const CachedObject &object);

public:

	HybridCache(const ProgramArguments &_args) : args(_args){};

	//Gets an object from the cache.
	//Returns true if it was found, false elsewise
	bool getObject(const FetchedObject &object);

	//Attempts to add on object to the cache
	//Returns true if it was, false otherwise
	void addToCache(const FetchedObject &object);

	inline int64_t getReplacementPolicyCalls(){return replacemetPolicyCalls;};
	inline int64_t getLargestObjectReplaced(){return largestObjectsReplaced;};
	inline double getMinUV(){return lowestUV;};
	inline double getMaxUV(){return highestUV;};

};

//Runs the simulation with the given arguments.
SimulationResults simulateHybridCache(ProgramArguments &args);

#endif
