package demo;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.List;

import model.Person;

/**
 * 
 * @author Ryan
 * Demo program for the GlobalX test.
 * Read the list of name from the text file. Sort the name list by last name and first name. Then output the new name list.
 */
public class Demo {
	public static void main(String[] args) throws Exception {
		
		try {
			//Read the file of name list.
			BufferedReader br = new BufferedReader(new FileReader("names.txt"));
			
	        List<Person> persons = new ArrayList<Person>();
			
	        String line = br.readLine();
	        
	        //Get the last name and first name for each person, and save them into Person object.
	        while (line != null) {
	        	String[] names = line.split(",");
	        	
	        	Person person = new Person();
	        	
	        	person.setLastName(names[0]);
	            person.setFirstName(names[1]);
	            
	            //Add each person into the list which will be used for sorting.
	            persons.add(person);
	            
	            line = br.readLine();
	        }
	        
	        br.close();
	        
	        //Sort the name list by last name and first name.
	        Collections.sort(persons, new Comparator<Person>(){
	        	public int compare(Person p1, Person p2) {
	        		int res =  p1.getLastName().compareToIgnoreCase(p2.getLastName());
	                if (res != 0)
	                    return res;
	                return p1.getFirstName().compareToIgnoreCase(p2.getFirstName());
	            }
	        });
	        
	        //Output the new name list
	        File file = new File("newNames.txt");
	        BufferedWriter output = new BufferedWriter(new FileWriter(file));
	        
	        StringBuilder sb = new StringBuilder();
	        
	        //Prepare the new string for the new file.
	        for (Person p : persons){
	        	sb.append(p.getLastName());
	        	sb.append(", ");
	        	sb.append(p.getFirstName());
	        	sb.append(System.lineSeparator());
	        }

	        String newNames = sb.toString();
	        
	        output.write(newNames);
	        output.close();
	        
	    } 
		
		catch (Exception e){
			System.out.print("Error occur. Please Check the code.");
		}
	}
}
