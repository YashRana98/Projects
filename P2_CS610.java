import java.io.*;
import java.util.*;

public class P2_CS610
{
  //counters to increment # of key comparisons
  public static int selectCount1=0;
  public static int selectCount2=0;
  public static int selectCount3=0;

  // First we have to see which n to compute for 1, 2, or 3 (default)
  public static int checkN(int val)  {
    if (val == 2)    {
      return 100000;
    }
    else if (val == 1)    {
      return 10000;
    }
    else    {
      return 1000000;
    }
  }

  public static void main(String[] args) throws IOException  {
    //beginning of main function declare variables
    double beginning;
    double finish;
    double elapsed;

    int kth_smallest_element;
    int length;

    //read input in from input buffer
    System.out.println("Type 1 for n=10000, 2 for n=100000, or 3 for n=1000000");
    BufferedReader inputbuffer = new BufferedReader(new InputStreamReader(System.in));
    int n =Integer.parseInt(inputbuffer.readLine());
    length = checkN(n);
    //use each of the three methods tofind the kth smallest element for k = n/2
    int k=length/2;
    int array1[]=new int[length];
    int array2[]=new int[length];
    int array3[]=new int[length];
    for(int count=0;count<length;count++)  {
      //random num
      int temp=(int)(Math.random()*length);
      array1[count]=temp;
      array2[count]=temp;
      array3[count]=temp;
    }
    //SELECT1: Sort the array using Quicksort and pick the kth smallest element. This has average time complexity of O(n log n) and worst-case time of O(n2)
    System.out.println("Using SELECT1:");
    //start timer here
    beginning=System.nanoTime();
    //do algorithm here with (dtype A[ ], int n, int k)
    select1(array1,0,length-1);
    kth_smallest_element=array1[k];
    finish=System.nanoTime();
    elapsed=(finish-beginning)/1000000.0;
    //end timer, calculate elapsed, show results in one line
    System.out.println("Algorithm 1: n="+length+" k="+k+""+" A["+k+"]="+kth_smallest_element+" Number of Key-Comparisons="+selectCount1+" Time="+elapsed+"ms");
    //repeat same steps for select2 and select3

    System.out.println("Using SELECT2:");
    beginning=System.nanoTime();
    kth_smallest_element=select2(array2,0,length-1,k);
    finish=System.nanoTime();
    elapsed=(finish-beginning)/1000000.0;
    System.out.println("Algorithm 2: n="+length+" k="+k+""+" A["+k+"]="+kth_smallest_element+" Number of Key-Comparisons="+selectCount2+" Time="+elapsed+"ms");

    System.out.println("Using SELECT3:");
    beginning=System.nanoTime();
    kth_smallest_element=select3(array3,0,length-1,k);
    finish=System.nanoTime();
    elapsed=(finish-beginning)/1000000.0;
    System.out.println("Algorithm 3: n="+length+" k="+k+""+" A["+k+"]="+kth_smallest_element+" Number of Key-Comparisons="+selectCount3+" Time="+elapsed+"ms");
  }
  //create swap func
  public static void swap(int array[], int count, int outer)  {
    int temp = array[count];
    array[count] = array[outer];
    array[outer] = temp;
  }
  //(Do not perform the key comparisons in-line. Rather, use a function to perform each key comparison, while incrementing a counter.)
  //use selectCount1 ++
  public static boolean compFunc1(int count,int outer){
    selectCount1=++selectCount1;
    if(count<outer){
      return(true);
    }
    else    {
      return(false);
    }
  }
  //use selectCount2 ++
  public static boolean compFunc2(int count,int outer){
    selectCount2=++selectCount2;
    if(count<outer){
      return(true);
    }
    else{
      return(false);
    }
  }
  //use selectCount3 ++
  public static boolean compFunc3(int count,int outer){
    selectCount3=++selectCount3;
    if(count<outer){
      return(true);
    }
    else{
      return(false);
    }
  }

  public static int quisel(int R2[],int index,int end,int k)  {
    int count,outer;
    int p2=(int)(Math.random()*(end-index))+index;
    int piv=R2[p2];
    swap(R2,index,p2);
    count=index+1;
    outer=end;
    while(count<=outer){
      if(compFunc2(R2[count],piv)){
        count++;
      }
      else if(R2[outer]>piv){
        outer--;
      }
      else{
        swap(R2,count,outer);
        count++;
        outer--;
      }
    }
    swap(R2,outer,index);
    if(k<outer){
      return(quisel(R2,index,outer,k));
    }
    else if(k>outer){
      return(quisel(R2,outer+1,end,k));
    }
    else{
      return(R2[k]);
    }
  }

  public static void bubble(int a[],int index,int end){
    int count,outer,temp;
    int length=end;
    for(count=index;count<length;++count){
      for(outer=index;outer<(length-count-1)+count;++outer){
        if(compFunc3(a[outer+1],a[outer])){
          temp=a[outer];
          a[outer]=a[outer+1];
          a[outer+1]=temp;
        }
      }
    }
  }

  public static int linear(int R3[],int index,int end){
    if(end!=1){
      int count,outer,temp,m;
      int fin=end/5;
      if((m=end%5)!=0){
        fin=fin+1;
      }
      for(count=0;count<fin;++count){
        if(count==fin-1 && m!=0){
          bubble(R3,count*5,count*5+m);
          temp=R3[count];
          R3[count]=R3[((5*count)+(count*5+m))/2];
          R3[((5*count)+(count*5+m))/2]=temp;
        }
        else{
          bubble(R3,count*5,count*5+5);
          temp=R3[count];
          R3[count]=R3[((5*count)+(count*5+5))/2];
          R3[((5*count)+(count*5+5))/2]=temp;
        }
      }
      return(linear(R3,index,fin));
    }
    else{
      return(R3[index]);
    }
  }

  public static int linsel(int R2[],int index,int end,int k){
    int count,outer,temp;
    int p2=(int)(Math.random()*(end-index))+index;
    int piv=R2[p2];
    swap(R2,index,p2);
    count=index+1;
    outer=end;
    while(count<=outer){
      if(compFunc3(R2[count],piv)){
        count++;
      }
      else if(R2[outer]>piv){
        outer--;
      }
      else{
        swap(R2,count,outer);
        count++;
        outer--;
      }
    }
    temp=R2[outer];
    R2[outer]=R2[index];
    R2[index]=temp;
    if(k<outer){
      return(linsel(R2,index,outer,k));
    }
    else if(k>outer){
      return(linsel(R2,outer+1,end,k));
    }
    else{
      return(R2[k]);
    }
  }

  //alg 1 quicksort
  public static void select1(int arr1[],int left,int last){
        int count,outer;
        if(left>=last){
            return;
        }
        else{
            int span = last-left;
            int piv=(int)(Math.random()*span)+left;
            // Pick a pivot element V in random
            int V=arr1[piv];
            swap(arr1,left,piv);
            count=left+1;
            outer=last;
            while(count<=outer){
                if(compFunc1(arr1[count],V))
                    count++;
                else
                if(arr1[outer]>V)
                    outer--;
                else{
                    swap(arr1, count,outer);
                    count++;
                    outer--;
                }
            }
            swap (arr1,outer,left);
            select1(arr1,left,outer);
            select1(arr1,outer+1,last);
        }
    }


  //alg 2 quickselect
  public static int select2(int R2[],int index,int end,int k)  {
    // check if n < 25
    if(R2.length<25){
      int count,outer;
      for(count=1;count<=end;++count){
        for(outer=count;outer>0;--outer){
          if(compFunc2(R2[outer],R2[outer-1])){
            swap(R2,outer,outer-1);
          }
          else{
            //break the if and do quick select
            break;
          }
        }
      }
      return(R2[k]);
    }
    else{
      return(quisel(R2,index,end,k));
    }
  }

  //alg 3 linearsearch
  public static int select3(int R3[],int index,int end,int k){
    int count,outer;
    if(R3.length<25){
      for(count=1;count<=end;++count){
        for(outer=count;outer>0;--outer){
          if(compFunc3(R3[outer],R3[outer-1])){
            swap(R3,outer,outer-1);
          }
          else{
            //break the if and do linear
            break;
          }
        }
      }
      return(R3[k]);
    }
    else{
      int piv=linear(R3,index,end+1);
      count=index+1;
      outer=end;
      while(count<=outer){
        if(compFunc3(R3[count],piv)){
          count++;
        }
        else if(R3[outer]>piv){
          outer--;
        }
        else{
          swap(R3,count,outer);
          count++;
          outer--;
        }
      }
      swap(R3,outer,index);
      if(k<outer){
        return(linsel(R3,index,outer,k));
      }
      else if(k>outer){
        return(linsel(R3,outer+1,end,k));
      }
      else{
        return(R3[k]);
      }
    }
  }
}
