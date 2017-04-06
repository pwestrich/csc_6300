
#utility information
CXX      := g++
CPPFLAGS := -std=c++11 -O0 -pedantic -Wall -Wextra -g
LDFLAGS  := $(CPPFLAGS)
AR 	 := ar -r
RM 	 := rm -f
MV 	 := mv

#build information
INC_DIRS :=
LIB_DIRS :=
LIBS 	 :=

#how we build things
COMPILE := $(CXX) $(CPPFLAGS) $(INC_DIRS) -c
LINK    := $(CXX) $(LDFLAGS) $(LIB_DIRS) -o

#what to build
TARGET := program3

#files
HEADER := $(wildcard *.h)
SOURCE := $(wildcard *.cpp)
OBJECT := $(patsubst %.cpp,%.o,$(wildcard *.cpp))

#arguments to the binary for make run
INFILE		:= 10.txt
EPA_BW 		:= 1
EPA_CD		:= 80
CLARK_BW	:= 1
CLARK_CD	:= 130
WB			:= 1
WF 			:= 1
CACHE_SIZE	:= 50

.PHONY: all clean run

all: $(TARGET)

clean:

	$(RM) $(TARGET) $(OBJECT)
	$(RM) -r *.dYSM

run: all

	./$(TARGET) $(INFILE) $(EPA_BW) $(EPA_CD) $(CLARK_BW) $(CLARK_CD) $(WB) $(WF) $(CACHE_SIZE)

$(TARGET): $(OBJECT)

	$(LINK) $(TARGET) $(OBJECT) $(LIBS)

main.o: main.cpp main.h hybrid_cache.h

	$(COMPILE) main.cpp

hybrid_cache.o: hybrid_cache.cpp hybrid_cache.h object.h

	$(COMPILE) hybrid_cache.cpp

object.o: object.cpp object.h

	$(COMPILE) object.cpp

#generic rule for anything missed
%.o: %.cpp %.h

	$(COMPILE) $<
