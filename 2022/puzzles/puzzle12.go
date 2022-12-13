package puzzles

import (
	"2022/common"
	"fmt"
	"log"
)

var lines []string
var columns int
var rows int
var startPoint point

var endPoint point

type point struct {
	x int
	y int
}

func setStartAndEndPoints() {
	for i := 0; i < rows; i++ {
		for j := 0; j < columns; j++ {
			if string(lines[i][j]) == "S" {
				startPoint = point{x: j, y: i}
			} else if string(lines[i][j]) == "E" {
				endPoint = point{x: j, y: i}
			}
		}
	}
}
func initData() {
	lines = common.GetInputLines("day12.txt", false)
	columns = len(lines[0])
	rows = len(lines)
	setStartAndEndPoints()
}

func normalizeRune(runeToNormalize uint8) uint8 {
	if runeToNormalize == 'S' {
		return 'a'
	} else if runeToNormalize == 'E' {
		return 'z'
	}
	return runeToNormalize
}

func getNeighbours(currentPoint point) []point {
	currentValue := normalizeRune(lines[currentPoint.y][currentPoint.x])
	rowDelta := []int{0, 0, 1, -1}
	columnDelta := []int{1, -1, 0, 0}

	var neighbours []point
	for i := 0; i < 4; i++ {
		x := currentPoint.x + columnDelta[i]
		y := currentPoint.y + rowDelta[i]
		if x < 0 || y < 0 || x >= columns || y >= rows {
			continue
		}
		neighbourValue := normalizeRune(lines[y][x])
		if int(neighbourValue)-int(currentValue) <= 1 {
			neighbours = append(neighbours, point{x: x, y: y})
		}
	}
	return neighbours
}

func solve() [][]point {
	prev := make([][]point, rows)
	for i := range prev {
		prev[i] = make([]point, columns)
		for j := 0; j < columns; j++ {
			prev[i][j] = point{x: -1, y: -1}
		}
	}
	visited := make([][]bool, rows)
	for i := range visited {
		visited[i] = make([]bool, columns)
	}
	queue := []point{startPoint}
	visited[startPoint.y][startPoint.x] = true
	for {
		if len(queue) == 0 {
			break
		}
		point := queue[0]
		queue = queue[1:]
		neighbours := getNeighbours(point)
		for _, neighbour := range neighbours {
			if !visited[neighbour.y][neighbour.x] {
				queue = append(queue, neighbour)
				visited[neighbour.y][neighbour.x] = true
				prev[neighbour.y][neighbour.x] = point
			}
		}
	}
	return prev
}

func getPath(prev [][]point) []point {
	var path []point
	for at := endPoint; at.x != -1 && at.y != -1; at = prev[at.y][at.x] {
		path = append(path, at)
	}
	return path
}

func runPuzzle12Part1() {
	initData()
	prev := solve()
	path := getPath(prev)
	fmt.Println("Fewest steps from S:", len(path)-1)
}

func runPuzzle12Part2() {
	initData()
	fewestSteps := -1
	for y, line := range lines {
		for x, rune := range line {
			if rune == 'a' || rune == 'S' {
				startPoint = point{x: x, y: y}
				prev := solve()
				path := getPath(prev)
				steps := len(path) - 1
				if steps != 0 && (fewestSteps == -1 || steps < fewestSteps) {
					fewestSteps = len(path) - 1
				}
			}
		}
	}
	fmt.Println("Fewest steps from any a:", fewestSteps)
}

func RunPuzzle12() {
	log.Println("--- STARTING PUZZLE 12 ---")
	runPuzzle12Part1()
	runPuzzle12Part2()
	log.Println("--- FINISHED PUZZLE 12 ---")
}
