#include<iostream>
#include<math.h>
using namespace std;

int main(){
    ios_base::sync_with_stdio(false);
    cin.tie(NULL);

    freopen("input.txt", "r", stdin);
    freopen("output.txt", "w", stdout);

    long long int a, b, res;

    cin >> a >> b;
    res = a + (b*b);
    cout << res << endl;

    return 0;
}
