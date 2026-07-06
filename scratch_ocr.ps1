[void][System.Reflection.Assembly]::LoadWithPartialName('System.Drawing')
[void][System.Reflection.Assembly]::Load("Windows, Version=255.255.255.255, Culture=neutral, PublicKeyToken=null, ContentType=WindowsRuntime")

try {
    # Initialize Windows Runtime types
    $OcrEngineType = [Type]::GetType('Windows.Media.Ocr.OcrEngine, Windows.Media.Ocr, ContentType=WindowsRuntime')
    if (-not $OcrEngineType) {
        Write-Output "OCR Engine class not found."
        exit
    }
    
    $Engine = [Windows.Media.Ocr.OcrEngine]::TryCreateFromUserProfileLanguages()
    if (-not $Engine) {
        Write-Output "Could not create OCR engine."
        exit
    }

    $brain_dir = "C:\Users\Imalee Livera\.gemini\antigravity-ide\brain\5c06bf1b-987d-4ab2-b4db-c3e6298f4785"
    $files = Get-ChildItem -Path $brain_dir -Filter "media__1779874*.png"
    foreach ($file in $files) {
        Write-Output "========================================"
        Write-Output "FILE: $($file.Name) ($($file.Length) bytes)"
        Write-Output "========================================"
        
        $asyncOp = [Windows.Storage.StorageFile]::GetFileFromPathAsync($file.FullName)
        while ($asyncOp.Status -eq 'Started') { Start-Sleep -Milliseconds 50 }
        $storageFile = $asyncOp.GetResults()
        
        $streamOp = $storageFile.OpenReadAsync()
        while ($streamOp.Status -eq 'Started') { Start-Sleep -Milliseconds 50 }
        $stream = $streamOp.GetResults()
        
        $decoderOp = [Windows.Graphics.Imaging.BitmapDecoder]::CreateAsync($stream)
        while ($decoderOp.Status -eq 'Started') { Start-Sleep -Milliseconds 50 }
        $decoder = $decoderOp.GetResults()
        
        $bitmapOp = $decoder.GetSoftwareBitmapAsync()
        while ($bitmapOp.Status -eq 'Started') { Start-Sleep -Milliseconds 50 }
        $bitmap = $bitmapOp.GetResults()
        
        $recognizeOp = $Engine.RecognizeAsync($bitmap)
        while ($recognizeOp.Status -eq 'Started') { Start-Sleep -Milliseconds 50 }
        $result = $recognizeOp.GetResults()
        
        Write-Output $result.Text
    }
} catch {
    Write-Output "Error occurred: $_"
    Write-Output $_.ScriptStackTrace
}
