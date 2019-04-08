#include<iostream>
using namespace std;

int main(){
    ios_base::sync_with_stdio(false);
    cin.tie(NULL);

    freopen("input.txt", "r", stdin);
    freopen("output.txt", "w", stdout);

    long long a, b;

    cin >> a >> b;
    cout << (a+b) << endl;

    return 0;
}
