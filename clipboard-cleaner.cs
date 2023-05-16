/*
* I had a faulty c in ctrl+c so instead of buying a new keyboard
* I wrote this to clear the clipboard so I avoid accidentale paste of
* unwanted items. It is bad paractice. But fun.
*/

using System;
using System.Threading;
using System.Windows.Forms;

namespace Clipboard_Cleaner
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }
       
        private void Form1_Load(object sender, EventArgs e)
        {
            while (true) {
                Thread.Sleep(10000);
                Clipboard.Clear();
            }

        }
    }
}
