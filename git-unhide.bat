REM Unhide GIT directory tree.
@ECHO OFF
ATTRIB -R -A -S -H /S /D ".\.git\*"