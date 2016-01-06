#include <bits/stdc++.h>
#include <unistd.h>
using namespace std;
#define MAXN 1000													//maximum number of vertices


vector<string> IpAddr;
vector<int> g[MAXN];
bool discovered[MAXN];
int n, e, activeLinks, brokenLinks;


void initialize();
void takeInput();
int isAlive(string ipAddr);
void mapNetwork();
void init_bftrav();
void display();


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
					sleep(1);
					cout << "Active link : " << u+1 << " <-> "<< m+1 << endl;
					discovered[m] = true;
					que.push(m);	
					activeLinks++;
				}
				else {
					cout << "** Broken link : " << u+1 << " <-> "<< m+1 << endl;	 
					brokenLinks++;
				}	
				
			}	
		}	
	}
	
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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
