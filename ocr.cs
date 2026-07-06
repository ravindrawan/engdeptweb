using System;
using System.Drawing;
using System.IO;
using System.Threading.Tasks;
using Windows.Graphics.Imaging;
using Windows.Media.Ocr;
using Windows.Storage;
using Windows.Storage.Streams;

class Program
{
    static void Main(string[] args)
    {
        RunOcr().Wait();
    }

    static async Task RunOcr()
    {
        try
        {
            string brainDir = @"C:\Users\Imalee Livera\.gemini\antigravity-ide\brain\5c06bf1b-987d-4ab2-b4db-c3e6298f4785";
            OcrEngine engine = OcrEngine.TryCreateFromUserProfileLanguages();
            if (engine == null)
            {
                Console.WriteLine("Could not create OCR engine.");
                return;
            }

            string[] files = Directory.GetFiles(brainDir, "media__1779874*.png");
            foreach (string file in files)
            {
                Console.WriteLine("========================================");
                Console.WriteLine("FILE: " + Path.GetFileName(file));
                Console.WriteLine("========================================");

                StorageFile storageFile = await StorageFile.GetFileFromPathAsync(file);
                using (IRandomAccessStream stream = await storageFile.OpenReadAsync())
                {
                    BitmapDecoder decoder = await BitmapDecoder.CreateAsync(stream);
                    SoftwareBitmap bitmap = await decoder.GetSoftwareBitmapAsync();
                    OcrResult result = await engine.RecognizeAsync(bitmap);
                    Console.WriteLine(result.Text);
                }
            }
        }
        catch (Exception ex)
        {
            Console.WriteLine("Error: " + ex.Message);
            Console.WriteLine(ex.StackTrace);
        }
    }
}
