package puzzles

import (
	"2022/common"
	"fmt"
	"log"
	"strconv"
	"strings"
)

type directory struct {
	parent      *directory
	name        string
	directories map[string]directory
	files       map[string]int
}

func printDirectoryStructure(dir directory, prevDirName string) {
	dirName := prevDirName + dir.name
	if len(dir.directories) > 0 {
		for _, subDir := range dir.directories {
			printDirectoryStructure(subDir, dirName)
		}
	}
}

func calculateDirectorySizes(dir directory, totalSum *int) int {
	fileSizeSum := 0
	for _, fileSize := range dir.files {
		fileSizeSum += fileSize
	}
	if len(dir.directories) > 0 {
		for _, subDir := range dir.directories {
			fileSizeSum += calculateDirectorySizes(subDir, totalSum)
		}
	}
	if fileSizeSum <= 100000 {
		*totalSum += fileSizeSum
	}
	return fileSizeSum
}

func findRootSize(rootDir directory) int {
	fileSizeSum := 0
	for _, fileSize := range rootDir.files {
		fileSizeSum += fileSize
	}
	if len(rootDir.directories) > 0 {
		for _, subDir := range rootDir.directories {
			fileSizeSum += findRootSize(subDir)
		}
	}
	return fileSizeSum
}

func calculateDirectoriesToRemove(dir directory, spaceNeeded int) int {
	fileSizeSum := 0
	for _, fileSize := range dir.files {
		fileSizeSum += fileSize
	}
	if len(dir.directories) > 0 {
		for _, subDir := range dir.directories {
			fileSizeSum += calculateDirectoriesToRemove(subDir, spaceNeeded)
		}
	}
	if fileSizeSum >= spaceNeeded {
		fmt.Println(dir.name, fileSizeSum)
	}
	return fileSizeSum
}

func runPuzzle7Part1() {
	lines := common.GetInputLines("day7.txt", false)
	rootDir := directory{directories: map[string]directory{}, files: map[string]int{}, name: "/"}
	currentDir := rootDir
	for _, line := range lines {
		if strings.HasPrefix(line, "$ cd") {
			dirName := strings.Split(line, " ")[2]
			if dirName == "/" {
				continue
			} else if dirName == ".." {
				currentDir = *currentDir.parent
			} else {
				parent := currentDir
				newDir := directory{parent: &parent, directories: map[string]directory{}, files: map[string]int{}, name: dirName}
				currentDir.directories[dirName] = newDir
				currentDir = newDir
			}
		} else if !strings.HasPrefix(line, "$") && !strings.HasPrefix(line, "dir") {
			slice := strings.Split(line, " ")
			size, _ := strconv.Atoi(slice[0])
			currentDir.files[slice[1]] = size
		}
	}
	//printDirectoryStructure(rootDir, "")
	totalSum := 0
	calculateDirectorySizes(rootDir, &totalSum)
	fmt.Println(totalSum)
}

func runPuzzle7Part2() {
	lines := common.GetInputLines("day7.txt", false)
	rootDir := directory{directories: map[string]directory{}, files: map[string]int{}, name: "/"}
	currentDir := rootDir
	for _, line := range lines {
		if strings.HasPrefix(line, "$ cd") {
			dirName := strings.Split(line, " ")[2]
			if dirName == "/" {
				continue
			} else if dirName == ".." {
				currentDir = *currentDir.parent
			} else {
				parent := currentDir
				newDir := directory{parent: &parent, directories: map[string]directory{}, files: map[string]int{}, name: dirName}
				currentDir.directories[dirName] = newDir
				currentDir = newDir
			}
		} else if !strings.HasPrefix(line, "$") && !strings.HasPrefix(line, "dir") {
			slice := strings.Split(line, " ")
			size, _ := strconv.Atoi(slice[0])
			currentDir.files[slice[1]] = size
		}
	}
	spaceNeeded := 30000000 - (70000000 - findRootSize(rootDir))
	fmt.Println(spaceNeeded)
	calculateDirectoriesToRemove(rootDir, spaceNeeded)
	//calculateDirectorySizes(rootDir,)
	//fmt.Println(dirSize)
	//fmt.Println(rootDir.files["b.txt"])
}

func RunPuzzle7() {
	log.Println("--- STARTING PUZZLE 7 ---")
	runPuzzle7Part1()
	runPuzzle7Part2()
	log.Println("--- FINISHED PUZZLE 7 ---")
}
