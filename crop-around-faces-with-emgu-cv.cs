/*
* Disclaimer: This is a very hastily made script to solve a small problem. It works, but not really
* optimized and might have totally needless things in it. Change it to your needs.
*
* Without changing the code this is what you need for this to work as is:
*
* 1. You need a Form Application.
*
* 2. Create a button named startBtn and a checkbox named debugMode.
*    (Debug mode will draw red rectangles around the face so you can see where it makes a mistake)
*    Also two TextBoxes named numOfDone and doneText
*
* 3. You will need to put the haarcascade_frontalface_alt.xml file next to it. You can download that
*    from this repo: https://github.com/opencv/opencv/tree/4.x/data/haarcascades You can try others
*    too.
*
* 4. In NuGet install Emgu.CV
*
* 5. The code will get images from the "input" folder next to the exe and put the results in the "output" folder
*
* 6. In the Build settings it worked for me with Any CPU setting, but others had to target x64 or x86. Depends
*    on your VisualStudio version. 
*
*/

using Emgu.CV;
using Emgu.CV.Structure;
using System;
using System.Diagnostics;
using System.Drawing;
using System.Drawing.Drawing2D;
using System.Drawing.Imaging;
using System.IO;
using System.Windows.Forms;

namespace image_crop
{
    public partial class Form1 : Form
    {
        public bool debugModeFlag = false;
        public Form1()
        {
            InitializeComponent();
           
        }

        private void Form1_Load(object sender, EventArgs e){
           
        }

        public void DetectFacesAndCrop(Boolean drawRectangles = false) {
            String[] fileList;

            int biggestWidth = 0;
            Rectangle biggestRec = new Rectangle();


            // this is where you use the model. Change the file if you want to recognize other things on the image
            CascadeClassifier facesCascadeClassifier = new CascadeClassifier("haarcascade_frontalface_alt.xml");
             //CascadeClassifier facesCascadeClassifier = new CascadeClassifier("haarcascade_frontalface_alt_tree.xml");

            // Create the input and output folders if they are not exist.
            Directory.CreateDirectory("input");
            Directory.CreateDirectory("output");

            // get the input files
            fileList = Directory.GetFiles("input");

            // setting up to save jpg. If you want png, you can lose all these
			// as Save() will produce PNG by default.
            ImageCodecInfo myImageCodecInfo;
            Encoder myEncoder;
            EncoderParameter myEncoderParameter;
            EncoderParameters myEncoderParameters;
            myImageCodecInfo = GetEncoderInfo("image/jpeg");

            myEncoder = Encoder.Quality;
            myEncoderParameters = new EncoderParameters(1);
            myEncoderParameter = new EncoderParameter(myEncoder, 100L);
            myEncoderParameters.Param[0] = myEncoderParameter;

            // the count of done images
            int counter = 0;

            for (int i = 0; i < fileList.Length; i++)
            {// loop through the files
                counter++;

                String[] fileData = fileList[i].Split('\\');

                Image imageFile = Image.FromFile(fileList[i]);

                Bitmap fileNow = new Bitmap(imageFile);

                Image<Bgr, byte> grayImage = fileNow.ToImage<Bgr, byte>();

                // arcfelismerés elvégzése, minden arc területét egy négyzet jelzi, egy képen számosat hoz lére
                Rectangle[] rectangles = facesCascadeClassifier.DetectMultiScale(grayImage, 1.1, 0, new Size(200, 200));

                
                foreach (Rectangle rectangle in rectangles)
                {
                    if (rectangle.Width > biggestWidth)
                    {
                        biggestWidth = rectangle.Width;
                        biggestRec = rectangle;
                    }

                    // this cuould be just debug mode checkbox tbh
                    if (drawRectangles)
                    {
                        using (Graphics gr = Graphics.FromImage(fileNow))
                        {
                            using (Pen pen = new Pen(Color.Red, 1))
                            {
                                gr.DrawRectangle(pen, rectangle);
                            }
                        }
                    }

                }

                // here is the target image size. Change these numbers if you want other images
                ResizeImage(fileNow, new Size(1200, 1600), biggestRec).Save("output/" + fileData[1], myImageCodecInfo, myEncoderParameters);

                biggestRec = new Rectangle();
                biggestWidth = 0;
            }

            doneText.Text = "Kész";
            doneText.Visible = true;
            
            numOfDone.Text = counter.ToString() + " fájl készült el!";
            numOfDone.Visible = true;

            startBtn.Enabled = true;
        }

        // I copied this from C# documentation
        private static ImageCodecInfo GetEncoderInfo(String mimeType)
        {
            int j;
            ImageCodecInfo[] encoders;
            encoders = ImageCodecInfo.GetImageEncoders();
            for (j = 0; j < encoders.Length; ++j)
            {
                if (encoders[j].MimeType == mimeType)
                    return encoders[j];
            }
            return null;
        }

	
        public static Image ResizeImage(Image imgToResize, Size destinationSize,Rectangle anchor)
        {


            var originalWidth = imgToResize.Width;
            var originalHeight = imgToResize.Height;

           
            var hRatio = (float)originalHeight / destinationSize.Height;
            var wRatio = (float)originalWidth / destinationSize.Width;

           
            var ratio = Math.Min(hRatio, wRatio);


            var wScale = Convert.ToInt32(destinationSize.Width * ratio);
            var hScale = Convert.ToInt32(destinationSize.Height * ratio);


            // this puts the face in the middle horizontaly
            var startX = anchor.X - (wScale -anchor.Width) / 2;
    
            
            var startY = 0;

			// do not mind this, never got around to test this part, it is 
			// most likely not needed :D 
            if (hRatio > destinationSize.Height)
            {
                startY = anchor.Y - Convert.ToInt32(300 * ratio);
            }
            else 
			{

                startY = (originalHeight - hScale) / 2;
            }

            
            var sourceRectangle = new Rectangle(startX, startY, wScale, hScale);

           
            var bitmap = new Bitmap(destinationSize.Width, destinationSize.Height);

           
            var destinationRectangle = new Rectangle(0, 0, bitmap.Width, bitmap.Height);

           
            using (var g = Graphics.FromImage(bitmap))
            {
                g.InterpolationMode = InterpolationMode.HighQualityBicubic;
                g.DrawImage(imgToResize, destinationRectangle, sourceRectangle, GraphicsUnit.Pixel);
            }

            return bitmap;

        }

        private void startBtn_Click(object sender, EventArgs e)
        {// start gomb kattintásával indul el a tömeges vágás
            startBtn.Enabled = false;

            doneText.Text = "Wait";
            doneText.Visible = true;

            numOfDone.Visible = false;
            DetectFacesAndCrop(debugMode.Checked); // DetectFacesAndCrop(true) if you want to debug
            Process.Start("explorer.exe", @"output");

        }

        private void debugMode_CheckedChanged(object sender, EventArgs e)
        {
            debugMode.ForeColor = Color.Silver;

            if (debugMode.Checked)
            {
                debugMode.ForeColor = Color.Red;
               
            }

          
        }
    }
}
