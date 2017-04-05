
#include "main.h"
#include "hybrid_cache.h"
#include "object.h"

HybridCache::calculateUV(const FetchedObject &object){



}

//Gets an object from the cache.
//Returns true if it was found, false elsewise
bool HybridCache::getObject(FetchedObject object){

	const std::string key = server2string(object.server) + object.resource;

	try {

		const size_t index = cacheMap[key];
		cache[index].hits += 1;
		return true;

	} catch (std::exception &ex){

		return false;

	}

}

//Attempts to add on object to the cache
//Returns true if it was, false otherwise
bool HybridCache::addToCache(FetchedObject object){

	

}


//Runs the simulation with the given arguments.
SimulationResults simulateHybridCache(const ProgramArguments &args){

	return {0,0,0,0,0,0};

}
