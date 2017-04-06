
#include <algorithm>
#include <cmath>
#include <iostream>

#include "main.h"
#include "hybrid_cache.h"
#include "object.h"

void HybridCache::calculateUV(CachedObject &object){

	if (object.object.server == ServerClark){
	
		object.uv = ((args.clark_cd + (args.wb / args.clark_bw)) * pow(object.hits + 1, args.wf)) / object.object.size;

	} else {

		object.uv =  ((args.epa_cd + (args.wb / args.epa_bw)) * pow(object.hits + 1, args.wf)) / object.object.size;

	}

	if (object.uv < lowestUV){

		lowestUV = object.uv;

	}

	if (object.uv > highestUV){

		highestUV = object.uv;

	}

}

//replaces some objects with the given one
void HybridCache::replaceObjects(const CachedObject &object){

	replacemetPolicyCalls += 1;
	
	//start looking for objects to boot out, starting with the lowest UV
	const int64_t sizeNeeded = object.object.size - (args.cache_size - currentCacheSize);
	int64_t sizeFreed = 0;
	int64_t index = sortedCache.size() - 1;

	std::vector<size_t> freeList;

	while ((sizeFreed < sizeNeeded) &&(index >= 0)){

		//only replace objects of a lower UV
		if (cache[sortedCache[index]].uv < object.uv){

			sizeFreed += cache[sortedCache[index]].object.size;
			freeList.push_back(sortedCache[index]);

		} else break; //when we hit this, there are no more objects of lower UV

		index -= 1;

	}

	//make sure we're about to free enough space.
	if (sizeFreed >= sizeNeeded){

		//free the items in the free list from the sorted list, map, and cache
		sortedCache.erase(sortedCache.end() - freeList.size(), sortedCache.end());

		for (size_t i = 0; i < freeList.size(); ++i){

			cacheMap.erase(cache[freeList[i]].object.resource);
			cache.erase(cache.begin() + freeList[i]);

		}

		//adjust cache size and add this to the list
		currentCacheSize -= sizeFreed;
		_addToCache(object);

		//keep track of how many items we trashed
		if (freeList.size() > largestObjectsReplaced){

			largestObjectsReplaced = freeList.size();

		}

	}

}

void HybridCache::_addToCache(const CachedObject &object){

	currentCacheSize += object.object.size;

	const size_t index = cache.size();

	cache.push_back(object);
	sortedCache.push_back(index);
	cacheMap[object.object.resource] = index;

	std::sort(sortedCache.begin(), sortedCache.end(), [this](const size_t left, const size_t right){

		return this->cache[left] > this->cache[right];

	});

}

//Gets an object from the cache.
//Returns true if it was found, false elsewise
bool HybridCache::getObject(const FetchedObject &object){

	try {

		//try to find the object in the map
		const size_t index = cacheMap.at(object.resource);
		cache[index].hits += 1;
		calculateUV(cache[index]);

		std::sort(sortedCache.begin(), sortedCache.end(), [this](const size_t left, const size_t right){

		return this->cache[left] > this->cache[right];

	});

		return true;

	} catch (std::exception &ex){

		return false;

	}

}

//Adds an object to the cache
void HybridCache::addToCache(const FetchedObject &object){

	const int64_t newSize = currentCacheSize + object.size;
	CachedObject cached = {object, 0, 0};
	calculateUV(cached);

	if (newSize <= args.cache_size){

		//object fits in cache, simply add it
		
		_addToCache(cached);

	} else {

		//replacement policy needs to be called
		replaceObjects(cached);

	}

}

//Runs the simulation with the given arguments.
SimulationResults simulateHybridCache(ProgramArguments &args){

	FetchedObject object;
	SimulationResults results = {0,0,0,0,0,0};
	HybridCache cache(args);

	while (args.infile >> object){

		//try to get object form cache
		const bool inCache = cache.getObject(object);

		//if object was in cache, increment the hit count
		if (inCache){

			results.cacheHits += 1;

		} else { //else, try to add to cache and increase miss count

			results.cacheMisses += 1;
			cache.addToCache(object);

		}

	}

	results.replacementPolicyCalls = cache.getReplacementPolicyCalls();
	results.maxObjectsReplaced 	 = cache.getLargestObjectReplaced();
	results.lowestUV 					 = cache.getMinUV();
	results.highestUV 				 = cache.getMaxUV();

	return results;

}
