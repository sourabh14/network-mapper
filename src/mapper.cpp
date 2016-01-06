#include <bits/stdc++.h>
#include <unistd.h>

#define MAXN 10000						//maximum number of vertices
#define INF 1000000

using namespace std;

struct node {
	int a;
	bool state;
};
typedef struct node NODE;
int n, i, e, a, b, q;
vector<NODE> g[MAXN];
bool discovered[MAXN];


void init1() {							
	//clear previous graph entries
	for (i=0; i<n; i++) g[i].clear();
}

void init2() {							
	//initialize for graph traversal	
	memset(discovered,0,sizeof(discovered));
}

inline void join(int a, int b) {		
	//for undirected graph 
	NODE n;
	n.a = b-1;
	n.state = false;
	g[a-1].push_back(n);
	n.a = a-1;
	g[b-1].push_back(n);			
}

void bftrav(int s) {					
	//s is the source	
	bool con;
	init2();		
	queue<int> que;		
	discovered[s] = true;
	que.push(s);
	
	while (!que.empty()) {
		int m;
		int u = que.front(); 
		que.pop();	
		
		for (unsigned int v=0; v<g[u].size(); v++) {		
			m = g[u][v].a;
			con = g[u][v].state;
			if (!discovered[m]) {
				sleep(1);
				//if m is reachable from u, i.e ping reply is positive
				if (!con) {
					cout << "\nBroken link : " << u+1 << " <-> "<< m+1 << endl << endl;
				}	
				else {							//push it to que
					cout << "Active link : " << u+1 << " <-> "<< m+1 << endl;
					discovered[m] = true;
					que.push(m);
				}	
			}	
		}	
	}
}	

void display() {
printf("\n----adjacency list------\n");
	for (int i=0;i<n;i++) {
		cout << i << "-> ";
		for (unsigned int j=0; j<g[i].size(); j++) {
			cout << "(" << (g[i][j].a) << ", " << g[i][j].state << "),  ";
		}
		cout << endl;
	}
	cout << "-------------------------\n";
}

int main() {
	//Initial graph structure
	cin >> n >> e;						//scan no of vertices and edges
	init1();
	while (e--) {
		cin >> a >> b;					//a and b are vertex no (1 based indexing)
		join(a,b);
	}
	//display();
	
										//current graph structure
	
	cin >> q;
	while (q--) {
		cin >> a >> b;
		for (unsigned int i=0; i<g[a-1].size(); i++) {
			if ((g[a-1][i].a) == (b-1)) {
				g[a-1][i].state = true;
				break;
			}
		}		
	}	
	//display();
									
							
							//for traversal- give source according to 0-based indexing
	bftrav(0);
	printf("\n");
	return 0;
}	
