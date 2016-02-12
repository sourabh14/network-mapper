/* This source code 
 * 		- takes input from txt files graphConnections.json
 * 		- creates graph adjacency list
 * 		- with 0 as source it breadth first traverses the graph
 * 		- using isAlive() function it detects the link's state
 * 		- state of all the links are written in linkState.json
 * 		- for json operations it uses json-cpp parser header and source file
 * 
 * Link states value:
 * 		0 - link is down
 * 		1 - link is up
 * 		2 - undiscovered link
 * 
 * 		-Initially all link states values are 2 in graphConnections.json
 */
#include <bits/stdc++.h>
#include <unistd.h>								// for popen()
#include "json-cpp/json.h"						// for json parsing							
		
using namespace std;
#define MAXN 10000								//maximum number of nodes

vector<string> IpAddr;
struct grNode {									//graph node			
	int val, handle;							//handle denotes the location of edge on 
} tmp;											//JSON object				
vector<grNode> g[MAXN];
bool discovered[MAXN];
int n, e, activeLinks, brokenLinks;
//json object
json::Object jsonObj;


void initialize();
void takeInput();
int isAlive(string ipAddr);
void mapNetwork();
void init_bftrav();
void display();
void addLink(int, int, int, int);
void createJsonOp();


//-------driver program------/

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
	//Take input from graphConnections.json to create graph and id to ipaddress mapping
	ifstream ifs; 
	ifs.open("graphConnections.json");
	
	if (!ifs.is_open()) {
		cout << "Cannot open file graphConnecitons.json" << endl;
		exit(EXIT_SUCCESS);
	}	
	
	string ip, jsonInput;
	while (getline(ifs, ip)) {
		jsonInput = jsonInput + ip;
	}	
	ifs.close();
	
	//deserialize json input
	json::Value input_val = json::Deserialize(jsonInput);
	if (input_val.GetType() == json::NULLVal) {
		cout << "Invalid json input" << endl;
		exit(EXIT_SUCCESS);
	}
	
	int n1, n2;
	string ipstr;
	jsonObj = input_val.ToObject();	
	json::Array lnk = jsonObj["links"];
	json::Array nds = jsonObj["nodes"];
	n = nds.size(); 
	e = lnk.size();
	
	//scan ip addresses of n nodes
	for (int i=0; i<n; i++) {
		ipstr = (string)nds[i]["ip"];
		IpAddr.push_back(ipstr);
	}
	
	//scan links 
	for (int i=0; i<e; i++) {
		n1 = lnk[i]["source"];
		n2 = lnk[i]["target"];	
		tmp.val = n2; tmp.handle = i;
		g[n1].push_back(tmp);
		tmp.val = n1; tmp.handle = i;
		g[n2].push_back(tmp);
	}	

}

void init_bftrav() {
	//initialization function before breadth first traversal
	memset(discovered, 0, sizeof discovered);
	activeLinks = brokenLinks = 0;
}		

void mapNetwork() {
	//Main driver program for mapping network
	
	//initialize before bf traversal
	init_bftrav();
	
	queue<int> que;
	unsigned int m, u, v;
	
	//our source is 0 - ping server		
	discovered[0] = true;
	que.push(0);
	
	while (!que.empty()) {
		u = que.front();  
		que.pop();	
		
		for (v=0; v<g[u].size(); v++) {					
			m = g[u][v].val;
			if (!discovered[m]) {						
				
				//check if host 'm' is alive
				if (isAlive(IpAddr[m])) {
					cout << "Active link : " << u << " <-> "<< m << endl;
					addLink(u, m, 1, g[u][v].handle);
					discovered[m] = true;
					que.push(m);	
					activeLinks++;
				}
				else {
					cout << "** Broken link : " << u << " <-> "<< m << endl;	 
					addLink(u, m, 0, g[u][v].handle);
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
	// Display graph adjacency list
	for (unsigned int i=0; i<IpAddr.size(); i++) {
		cout << "i : " << i << " ip : " << IpAddr[i] << endl;
	}	
	
	printf("\n----adjacency list------\n");
	for (int i=0;i<n;i++) {
		printf("%d -> ",i);
		for (int j=0; j<(int)g[i].size(); j++) {
			printf("%d,  ",g[i][j].val);
		}
		printf("\n");
	}
	printf("-------------------------\n");
}
	
void addLink(int n1, int n2, int state, int handle) {
	// search n1 n2 link and change state of it
	jsonObj["links"][handle]["value"] = state;
}	

void createJsonOp() {
	// write output state of links on linkState.json
	ofstream ofs;
	ofs.open("linkState.json");
	
	if (!ofs.is_open()) {
		cout << "Cannot open file linkState.json" << endl;
		exit(EXIT_SUCCESS);
	}	
	
	string ser = json::Serialize(jsonObj);
	ofs << ser;
	ofs.close();
}	
	
