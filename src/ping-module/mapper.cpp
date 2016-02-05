/* This source code 
 * 		- takes input from txt files grphConnections.txt and IPaddresses.txt
 * 		- creates graph adjacency list
 * 		- with 0 as source it breadth first traverses the graph
 * 		- using isAlive() function it detects the link's state
 * 		- state of all the links are written in linkState.json
 * 		- for json operations it uses json-cpp parser header and source file
 */ 
#include <bits/stdc++.h>
#include <unistd.h>								// for popen()
#include "json-cpp/json.h"						// for json parsing							
		
using namespace std;
#define MAXN 10000								//maximum number of nodes


vector<string> IpAddr;
vector<int> g[MAXN];
bool discovered[MAXN];
int n, e, activeLinks, brokenLinks;
json::Array outputArray;


void initialize();
void takeInput();
int isAlive(string ipAddr);
void mapNetwork();
void init_bftrav();
void display();
void addLink(int, int, int);
void createJsonOp();


/*-------driver program------*/

int main() {
	initialize();
	
	//start mapping network
	mapNetwork();
	
	return 0;
}


//-----------functions----------

void initialize() {
	//populate IpAddr and graph adjacency list
	takeInput();	
	//display();
}

void takeInput() {
	//Take input from files to create graph and id to ipaddress mapping
	ifstream ipfile("IPaddresses.txt"), grph("graphConnections.txt");
	int id, i, a, b;
	string addr;
	
	while (ipfile >> id >> addr) {
		IpAddr.push_back(addr);
	}	
	ipfile.close();
	
	//scan no of vertices and edges
	grph >> n >> e;
	for (i=0; i<e; i++) {
		grph >> a >> b;
		//vertices are in 0 based indexing with 0 as ping server
		g[a].push_back(b);
		g[b].push_back(a);			
	}	
	grph.close();
}

void init_bftrav() {
	memset(discovered, 0, sizeof discovered);
}		

void mapNetwork() {
	//initialize before bf traversal
	init_bftrav();
	activeLinks = brokenLinks = 0;
	queue<int> que;
	unsigned int m, u, v;
	
	//our source is 0 - ping server		
	discovered[0] = true;
	que.push(0);
	
	while (!que.empty()) {
		u = que.front();  
		que.pop();	
		
		for (v=0; v<g[u].size(); v++) {					
			m = g[u][v];
			if (!discovered[m]) {						
				
				//check if host 'm' is alive
				if (isAlive(IpAddr[m])) {
					//sleep(1);
					cout << "Active link : " << u << " <-> "<< m << endl;
					addLink(u, m, 1);
					discovered[m] = true;
					que.push(m);	
					activeLinks++;
				}
				else {
					cout << "** Broken link : " << u << " <-> "<< m << endl;	 
					addLink(u, m, 1);
					brokenLinks++;
				}	
				
			}	
		}	
	}
	
	createJsonOp();
	
	/*
	* statistics
	*/
	cout << "\n--Mapping Complete--\nNetwork statistics : \nActive links : " << 
	activeLinks << "\nBroken links : " << brokenLinks << endl << endl;
}	

int isAlive(string ipAddr) {
	/*Check if host is alive or not
	 * alive - return 1
	 * else - return 0
	 */
	 string cmdcpp;
	 char ch, cmd[100];
	 FILE *cmdOutput;
	 
	 cmdcpp = "ping " + ipAddr + " -c 1 | grep Destination | wc -l";
	 strcpy(cmd, cmdcpp.c_str());
	 if (!(cmdOutput = popen(cmd, "r"))) {
		 cout << "popen failed\n";
	 }
	 
	 ch = fgetc(cmdOutput);
	 	 
	 if (ch == '0') return 1;
	 else return 0;
}
	
void display() {
	//display graph adjacency list
	printf("\n----adjacency list------\n");
	for (int i=0;i<n;i++) {
		printf("%d -> ",i+1);
		for (int j=0; j<(int)g[i].size(); j++) {
			printf("%d,  ",g[i][j]+1);
		}
		printf("\n");
	}
	printf("-------------------------\n");
}
	
void addLink(int n1, int n2, int state) {
	//add link from n1 to n2 and state to arr(json)
	json::Object obj;
	obj["source"] = n1;
	obj["target"] = n2;
	obj["state"] = state;
	outputArray.push_back(obj);
}	

void createJsonOp() {
	//output state of links on linkState.json
	json::Object outp;
	outp["links"] = outputArray;
	string str = json::Serialize(outp);	
	ofstream ops("linkState.json");
	ops << str;
	ops.close();
}	
	
	
	
	
	
	
	
	
	
	
	
	
