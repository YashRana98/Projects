//Yash Rana CS610-002
import java.util.Random;
public class Program_Assignment_1_Yash {

	//Initialize Arrays for Part 1
	static int[] a1 =new int[32];
	static int[] a2 =new int[32];
	static int[] a3 =new int[32];
	static int[] Temp1 =new int[32];
	static int[] Temp2 =new int[32];
	static int[] Temp3 =new int[32];

	//Fills empty array with random integers with no duplicates
	public static int[] randomIntArray(int s) {
		Random random = new Random();
		int Temp4[] = new int[s];
		int i = 0;

		while (i < s) {
			boolean isSame = false;
			int rInt = random.nextInt(s) + 1;

			for (int j = 0; j < i; j++) {
				if (Temp4[j] == rInt) {
					isSame = true;
					break;
				}
			}
			if (isSame) {
				continue;
			}
			else {
				Temp4[i++] = rInt;
			}
		}
		return Temp4;
	}

	//Reverses values in an already initialized Array
	public static void ReverseArr() {

		int i=a2.length;
		int j=0;

		while(i>0) {
			a2[j]= i;
			j++;
			i--;
		}
	}

	//Sorts an unsorted Array in numerical order
	public static void SortedArray() {
		int i=1;
		int j=0;

		while(i<=a1.length) {
			a1[j]= i;
			j++;
			i++;
		}
	}

	//Creates the output for the Array to be seen when program is ran
	public static void OutputArray(int printArray1[]) {

		for (int i=0;i<printArray1.length;i++) {
			System.out.print(printArray1[i]+" ");
		}
		System.out.print("\n");
	}

	//Main Function with functions and arrays outputted
	public static void main(String[] args) {
		double clockStart, clockEnd, duration;
		SortingAlgorithm alg= new SortingAlgorithm();

		//First we sort our First Array and output it.

		System.out.println("This is where Part 1 begins: \n");

		SortedArray();
		System.out.print("Sorted Array:"  + "\n");
		OutputArray(a1);
		System.out.println();

		//Next we reverse the already sorted array.
		ReverseArr();
		System.out.print("Reversely Sorted Array:" + "\n");
		OutputArray(a2);
		System.out.println();

		//Next we create a randomly generated Array and output it.
		a3 = randomIntArray(a3.length);
		System.out.print("Randomly Generated Array:" + "\n");
		OutputArray(a3);
		System.out.println();

		Temp1=alg.copy(a1);
		Temp2=alg.copy(a2);
		Temp3=alg.copy(a3);

		//--------------------------MERGE SORT------------------------

		System.out.println("********************************");
		System.out.println("1. MERGE SORT");
		System.out.println("********************************");

		System.out.println("→ 1.Sorted Array");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.merge(a1);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0;
		System.out.println("TIME TAKEN = " + duration + " ms");
		System.out.print(" This is the Sorted Array:" + "\n");
		OutputArray(a1);
		System.out.println("");

		System.out.println("→ 2.Reversed Sorted Array ");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.merge(a2);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms");
		System.out.print(" This is the Sorted Array:"+"\n");
		OutputArray(a2);
		System.out.println("");

		System.out.println("→ 3.Random Array ");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.merge(a3);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms");
		System.out.print(" This is the Sorted Array:"+"\n");
		OutputArray(a3);

		System.out.print("");
		System.out.print("\n");
		System.out.print("\n");

		a1=alg.copy(Temp1);
		a2=alg.copy(Temp2);
		a3=alg.copy(Temp3);

		System.out.println("********************************");
		System.out.println("2. HEAP SORT");
		System.out.println("********************************");

		System.out.println("→ 1.Sorted Array ");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.heapsort(Temp1);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms");
		System.out.print(" This is the Sorted Array:"+"\n");
		OutputArray(Temp1);
		System.out.println("");

		System.out.println("→ 2.Reverse Sorted Array ");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.heapsort(Temp2);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms");
		System.out.print(" This is the Sorted Array:"+"\n");
		OutputArray(Temp2);
		System.out.println("");

		System.out.println("→ 3.Random Array ");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.heapsort(Temp3);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms");
		System.out.print(" This is the Sorted Array:"+"\n");
		OutputArray(Temp3);
		System.out.println("");

		System.out.println("********************************");
		System.out.println("3. QUICK SORT RESULTS");
		System.out.println("********************************");

		System.out.println("→ 1.Sorted Array ");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.qSort(a1);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms");
		System.out.print(" This is the Sorted Array:"+"\n");
		OutputArray(a1);
		System.out.println("");

		System.out.println("→ 2.Reverse Sorted Array ");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.qSort(a2);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms");
		System.out.print(" This is the Sorted Array:"+"\n");
		OutputArray(a2);
		System.out.println("");

		System.out.println("→ 3.Random Array ");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.qSort(a3);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms");
		System.out.print(" This is the Sorted Array:"+"\n");
		OutputArray(a3);
		System.out.println("");

		// part 2 begins we use bigger arrays here which causes program to take longer time
		System.out.println("This is Where Part 2 begins: \n");
		int TMAX = 1024;
		int BMAX = 32768;
		int MMAX = 1048576;

		int[] arry_1 =new int[TMAX];
		int[] arry_2 =new int[BMAX];
		int[] arry_3 =new int[MMAX];

		int[]tempa1 =new int [TMAX];
		int[]tempa2 =new int [BMAX];
		int[]tempa3 =new int [MMAX];

		arry_1 = randomIntArray(TMAX);
		arry_2 = randomIntArray(BMAX);
		arry_3 = randomIntArray(MMAX);

		tempa1 = alg.copy(arry_1);
		tempa2 = alg.copy(arry_2);
		tempa3 = alg.copy(arry_3);

		System.out.println(" ");
		System.out.println("********************************");
		System.out.println("1.MERGE SORT RESULTS");
		System.out.println("********************************");

		System.out.print("A) N = "+arry_1.length + "\n");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.merge(arry_1);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms");
		System.out.println("");

		System.out.print("B) N = "+arry_2.length+ "\n");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.merge(arry_2);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms"+ "\n");

		System.out.print("C) N = "+arry_3.length+ "\n");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.merge(arry_3);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms");

		arry_1 = alg.copy(tempa1);
		arry_2 = alg.copy(tempa2);
		arry_3 = alg.copy(tempa3);

		System.out.println(" ");
		System.out.println("********************************");
		System.out.println("2.HEAP SORT RESULTS");
		System.out.println("********************************");

		System.out.print("A) N = "+tempa1.length + "\n");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.heapsort(tempa1);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms" + "\n");

		System.out.print("B) N = "+tempa2.length + "\n");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.heapsort(tempa2);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms"+ "\n");

		System.out.print("C) N = "+tempa3.length+ "\n");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.heapsort(tempa3);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms"+ "\n");

		System.out.println(" ");
		System.out.println("********************************");
		System.out.println("3.Quick SORT RESULTS");
		System.out.println("********************************");

		System.out.print("A) N = "+arry_1.length);
		System.out.println("");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.qSort(arry_1);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms" + "\n");

		System.out.print("B) N = "+arry_2.length+ "\n");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.qSort(arry_2);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms"+ "\n");

		System.out.print("C) N = "+arry_3.length+ "\n");
		alg.resetCOMPCOUNT();
		clockStart= System.nanoTime();
		alg.qSort(arry_3);
		clockEnd= System.nanoTime();
		duration=(clockEnd-clockStart)/1000000.0  ;
		System.out.println("TIME TAKEN = "+duration+" ms" + "\n");

		System.out.println("This is the end of the program.");
	}
}

class SortingAlgorithm	{

	static int COMPCOUNT;
	SortingAlgorithm() {}

		public void resetCOMPCOUNT() {
			COMPCOUNT=0;
		}

		public int[] copy(int[] mergeArray) {

			int[] cArray= new int[mergeArray.length];

			for(int i= 0; i<mergeArray.length;i++) {
				cArray[i]= mergeArray[i];
			}

			return cArray;
		}

		public static void COMPCHECK(int i, int j) {
			COMPCOUNT++;
		}

		public void merge(int [] mergeArray) {
			mergesortLeft(mergeArray,0,mergeArray.length-1);
			System.out.println("COMPARISON = "+COMPCOUNT+"    ");
		}

		public void mergesortLeft(int[] mergeArray,int left,int right) {
			if(left >= right) {
				return;
			}
			else {
				int avg = (left+right)/2;
				mergesortLeft(mergeArray, left, avg);
				mergesortLeft(mergeArray, avg+1, right);
				mergesortRight(mergeArray,left,right);
			}
		}

		private void mergesortRight(int[] mergeArray, int left, int right) {

			int[] temp = copy(mergeArray);
			int avg = (left + right)/2;
			int i1 = 0;
			int i2 = left;
			int i3 = avg + 1;

			while (i2 <= avg && i3 <= right) {
				COMPCHECK(mergeArray[i2],mergeArray[i3]);

				if (mergeArray[i2] < mergeArray[i3]) {
					temp[i1] = mergeArray[i2];
					i1++;
					i2++;
				}
				else {
					temp[i1] = mergeArray[i3];
					i1++;
					i3 ++;
				}
			}
			while (i2 <= avg) {
				temp[i1] = mergeArray[i2];
				i1++;
				i2++;
			}

			while (i3  <= right) {
				temp[i1] = mergeArray[i3];
				i1++;
				i3 ++;
			}

			for (int i=left, j=0; i<=right; i++, j++) {
				mergeArray[i] = temp[j];
			}
		}

		public void heapsort(int arry[]) {
			int len = arry.length-1;

			for (int i = len/ 2 ; i >= 0; i--) {
				heap(arry, len+1, i);
			}

			for (int i=len; i>=0; i--) {
				change(arry,0,i);
				heap(arry, i, 0);
			}

			System.out.println("COMPARISON = "+ COMPCOUNT);
		}

		void heap(int arr[], int len, int i) {
			int largest = i;
			int left = 2*i + 1;
			int right = 2*i + 2;

			if (left < len && arr[left] > arr[largest]) {
				largest = left;
			}

			if (right< len && arr[right] > arr[largest]) {
				largest = right;
			}

			if (largest != i) {
				int change = arr[i];
				arr[i] = arr[largest];
				arr[largest] = change;
				heap(arr, len, largest);
			}
			COMPCHECK(left ,right);
		}
		public void qSort(int[] arrayCOMP) {
			qSort(arrayCOMP,0,arrayCOMP.length-1);
			System.out.println("COMPARISON="+COMPCOUNT+"   ");
		}
		public static void change(int[] arr, int i, int j) {
			int t = arr[i];
			arr[i] = arr[j];
			arr[j] = t;
		}
		private int breakUp(int[] arrayCOMP, int small, int large) {
			int pivot = arrayCOMP[small];
			do {
				while (small < large && arrayCOMP[large] >= pivot) {
					large--;
					COMPCHECK(arrayCOMP[large], pivot);
				}

				if (small < large) {
					arrayCOMP[small] = arrayCOMP[large];

					while (small < large && arrayCOMP[small] <= pivot) {
						small++;
						COMPCHECK(arrayCOMP[large], pivot);
					}

					if (small < large) {
						arrayCOMP[large] = arrayCOMP[small];
					}
				}
			}
			while (small < large);
			arrayCOMP[small] = pivot;
			return small;
		}
		private void qSort(int[] arrayCOMP, int small, int large) {
			if (small < large) {
				int avg = breakUp(arrayCOMP,small,large);
				qSort(arrayCOMP,small,avg-1);
				qSort(arrayCOMP,avg+1,large);
			}
		}
	}
