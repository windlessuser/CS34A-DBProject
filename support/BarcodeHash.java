package support;
import java.util.*;

public class BarcodeHash {


	public static void main (String [] args){
		
		Random rand = new Random();
		int offset;
		if(args[1].equals(""))
			offset = 0;
		else{
				try{
					offset = Integer.parseInt(args[1]);
				}catch(Exception e){
					offset = 0;
				}
			}

		char [] toHash = args[0].toCharArray();
		if(toHash.length < 10){
		 char [] temp = new char [10];
		 
		 for( int i = 0; i < toHash.length; i++){
			temp[i] = toHash[i];
		 }
		 for(int i = toHash.length; i < temp.length; i++){
			temp[i] = (char)(rand.nextInt(26) + 97);
		 }
		 toHash = new char[10];
		 for( int i = 0; i < temp.length; i++){
			toHash[i] = temp[i];
		 }
		}
		if(toHash.length > 10){
			char [] temp = new char [10];
			for(int i = 0; i < 10; i++){
				temp [i] = toHash[i];
			}
			toHash = new char[10];
			for( int i = 0; i < 10; i++){
				toHash[i] = temp[i];
			}
		}		
		String intString = "";		
		for(int i = 0; i < toHash.length; i++){		
			intString += Integer.toString(((int)toHash[i])%10 + offset);
		}
		System.out.println(intString.substring(0,10));
	}

}