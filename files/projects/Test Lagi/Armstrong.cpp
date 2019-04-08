#include<bits/stdc++.h>
using namespace std;

int main(){
    int n, temp, cnt = 0;
    vector<int> digs;

    cin >> n;
    temp = n;

    while(temp > 0){
        digs.push_back(temp % 10);
        temp /= 10;
        cnt++;
    }

    int tot = 0;

    for(int i = 0; i < digs.size(); i++){
        tot += pow(digs[i], cnt);
    }

    cout << ((n == tot) ? "Armstrong, " : "Not Armstrong, ");
    if(cnt < 3) cout << "less than 3 digits\n";
    else if(cnt > 3) cout << "more than 3 digits\n";
    else cout << "equal to 3 digits\n";

    return 0;
}