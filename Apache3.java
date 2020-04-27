/* MSC2 - N3 Go Bama Roll Tide Assignment: Group MM
 * Group Members:  Anthony Anderson (aa2296), Shreena Mehta (sm2327), Yash Rana (yr83)
 */
import java.io.IOException;
import java.net.DatagramPacket;
import java.net.InetAddress;
import java.net.MulticastSocket;
import java.net.UnknownHostException;

public class MSC2 
{
    public static void main(String[] args) throws UnknownHostException 
    {
		    MulticastSocket c;
	      if (args.length < 2) 
        {
	        System.out.println(" Usage: MSC2 <addr> <port>(addr = valid multicast group addr)\n");
	        System.exit(2);
	      }

        InetAddress address = InetAddress.getByName(args[0]); /* C1: cmd line arg 1 */
		    int PORT =  Integer.parseInt(args[1]);  /* C2: cmd line arg 2 */
		    String msg;
        
        byte[] buf = new byte[1024];
        int n=0; 

        try 
        {
			/* C3: create socket and join multicast group (two lines only) */
			      c = new MulticastSocket(PORT);
      			c.joinGroup(address);
      
            System.out.println(" USS Alabama on patrol: " + args[0] +":"+args[1] );
     
            for(n=0; n < 10; n++) 
            {
				/* NOTE: do NOT make any code changes outside this for loop (except C1,C2,C3)
 				 * There should be no more than 20-25 lines of code between here and the end of the loop */ 
				/* receive a "multicast" packet into buffer, print its contents */
                DatagramPacket packet;
                packet = new DatagramPacket(buf, buf.length);
                c.receive(packet);
                msg = new String(packet.getData());
                String inetaddress = (packet.getAddress()).getHostAddress();
                int portnum = packet.getPort();
                if(n == 0){
                      address = InetAddress.getByName(inetaddress);
                      PORT = portnum;
                }
                System.out.println(" " + n + " FLASH TRAFFIC: E.A.M Received from /" + inetaddress + " / " + msg);
                buf = null;
                buf = new byte[1024];
                if(address.getHostAddress().equals(inetaddress) && PORT == portnum)
                {     
                  DatagramPacket ping = new DatagramPacket("PING".getBytes(), "PING".length(), InetAddress.getByName(args[0]), Integer.parseInt(args[1]));
                  c.send(ping);
                } 
            }
      			if (n >= 10) { System.out.println(" Akula hunter killer -- die!\n"); }
      			else { System.out.println(" Success!\n"); } // NOTE -- this is not reached!!
         } catch (IOException ex) 
         {
             ex.printStackTrace();
         }
    }
}